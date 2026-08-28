import os
import re
import sys
from typing import List, Dict, Any, Optional, Tuple
import pandas as pd
import pdfplumber
from tqdm import tqdm

from config import (
    INPUT_PDF_PATH,
    OUTPUT_EXCEL_PATH,
    OUTPUT_CSV_PATH,
    DEFAULT_SCHOOL,
    DEFAULT_TAHUN_AJARAN,
    DEFAULT_SEMESTER,
    DEFAULT_SESI,
    KNOWN_DAYS,
    REGEX_TEACHER_CODE_NAME,
    REGEX_SESI,
    REGEX_TAHUN_AJARAN,
    REGEX_SEMESTER,
    EMPTY_SLOT_INDICATOR
)
from utils import logger, group_words_into_lines, parse_cell_lines

class FETScheduleParser:
    def __init__(self, pdf_path: str = INPUT_PDF_PATH):
        self.pdf_path = pdf_path
        self.records: List[Dict[str, Any]] = []
        
        # Statistics
        self.stats = {
            "total_pages": 0,
            "total_classes": 0,
            "parsed_slots": 0,
            "empty_slots": 0,
            "parsing_errors": 0
        }
        
    def parse(self) -> List[Dict[str, Any]]:
        """
        Main entry point to parse the PDF schedule.
        """
        logger.info(f"Starting parsing of PDF file: {self.pdf_path}")
        
        if not os.path.exists(self.pdf_path):
            logger.error(f"Input PDF file not found at: {self.pdf_path}")
            self.stats["parsing_errors"] += 1
            return []
            
        try:
            with pdfplumber.open(self.pdf_path) as pdf:
                self.stats["total_pages"] = len(pdf.pages)
                logger.info(f"Found {len(pdf.pages)} pages in the PDF.")
                
                # Iterate pages with tqdm progress bar
                for page_idx, page in enumerate(tqdm(pdf.pages, desc="Parsing schedule pages")):
                    page_num = page_idx + 1
                    try:
                        self._parse_page(page, page_num)
                    except Exception as e:
                        logger.error(f"Error parsing page {page_num}: {e}", exc_info=True)
                        self.stats["parsing_errors"] += 1
                        
        except Exception as e:
            logger.critical(f"Failed to open or read PDF file: {e}", exc_info=True)
            self.stats["parsing_errors"] += 1
            
        logger.info("Parsing completed.")
        return self.records

    def _get_grid_lines(self, page: pdfplumber.page.Page) -> Tuple[List[float], List[float]]:
        """
        Extracts unique vertical and horizontal lines/rect boundaries from the page.
        """
        v_lines = []
        h_lines = []
        for line in page.lines:
            if abs(line["x0"] - line["x1"]) < 0.1:
                v_lines.append(line["x0"])
            if abs(line["top"] - line["bottom"]) < 0.1:
                h_lines.append(line["top"])
        for rect in page.rects:
            v_lines.extend([rect["x0"], rect["x1"]])
            h_lines.extend([rect["top"], rect["bottom"]])
            
        def group_coords(coords, tol=1.5):
            if not coords:
                return []
            sorted_coords = sorted(coords)
            grouped = [sorted_coords[0]]
            for c in sorted_coords[1:]:
                if c - grouped[-1] <= tol:
                    grouped[-1] = (grouped[-1] + c) / 2
                else:
                    grouped.append(c)
            return [round(x, 2) for x in grouped]
            
        return group_coords(v_lines), group_coords(h_lines)

    def _finalize_and_add_records(
        self, lines: List[str], periods: List[int], day_name: str, class_name: str,
        tahun_ajaran: str, semester: str, session: str
    ):
        """
        Parses buffer lines into subject, teacher, and room, and appends records.
        """
        parsed = parse_cell_lines(lines, REGEX_TEACHER_CODE_NAME, EMPTY_SLOT_INDICATOR)
        if not parsed:
            return
            
        subject = parsed["subject"]
        teacher = parsed["teacher"]
        teacher_code = parsed["teacher_code"]
        room = parsed["room"]
        
        if not subject:
            if teacher:
                logger.warning(f"Class '{class_name}', Day '{day_name}', Periods {periods}: Subject is empty for teacher '{teacher}'.")
                self.stats["parsing_errors"] += 1
            return
            
        is_system_text = any(term in subject.lower() for term in ["jadwal", "fet", "dihasilkan", "dibuat pada"])
        if is_system_text:
            return
            
        if not teacher:
            logger.warning(f"Class '{class_name}', Day '{day_name}', Periods {periods}: Teacher name not found for subject '{subject}'.")
            self.stats["parsing_errors"] += 1
            
        for p_num in periods:
            record = {
                "Tahun Ajaran": tahun_ajaran,
                "Semester": semester,
                "Sesi": session,
                "Kelas": class_name,
                "Hari": day_name,
                "Jam Ke": p_num,
                "Mata Pelajaran": subject,
                "Guru": teacher,
                "Kode Guru": teacher_code,
                "Ruang": room
            }
            self.records.append(record)
            self.stats["parsed_slots"] += 1

    def _parse_page(self, page: pdfplumber.page.Page, page_num: int):
        """
        Parses a single page (representing one class schedule).
        """
        words = page.extract_words()
        if not words:
            logger.warning(f"Page {page_num} is empty (no words found). Skipping.")
            self.stats["parsing_errors"] += 1
            return

        # 1. Detect column (day) headers
        day_words = []
        for word in words:
            text_cap = word["text"].capitalize()
            if text_cap in KNOWN_DAYS:
                day_words.append(word)
                
        if not day_words:
            logger.warning(f"No day headers found on page {page_num}. Skipping page.")
            self.stats["parsing_errors"] += 1
            return
            
        day_words_sorted = sorted(day_words, key=lambda w: w["x0"])
        first_day_top = day_words_sorted[0]["top"]
        day_elements = [w for w in day_words_sorted if abs(w["top"] - first_day_top) <= 5]
        
        header_bottom = max(w["bottom"] for w in day_elements)
        first_day_x0 = day_elements[0]["x0"]

        # 2. Extract Top Section Metadata
        top_words = [w for w in words if w["bottom"] < first_day_top]
        top_lines = group_words_into_lines(top_words, tolerance=4.0)
        
        school_name = DEFAULT_SCHOOL
        session = DEFAULT_SESI
        tahun_ajaran = DEFAULT_TAHUN_AJARAN
        semester = DEFAULT_SEMESTER
        class_name = ""

        parsed_school_candidate = []
        for line in top_lines:
            line_str = line.strip()
            if not line_str:
                continue
                
            sesi_match = REGEX_SESI.search(line_str)
            if sesi_match:
                session = sesi_match.group(1)
                continue
                
            ta_match = REGEX_TAHUN_AJARAN.search(line_str)
            if ta_match:
                tahun_ajaran = ta_match.group(1)
                
            sem_match = REGEX_SEMESTER.search(line_str)
            if sem_match:
                semester = sem_match.group(1).capitalize()
                
            if any(term in line_str.upper() for term in ["SMK", "SMA", "SMP", "NEGERI", "SEKOLAH"]):
                school_name = line_str
            else:
                if not REGEX_TAHUN_AJARAN.search(line_str) and not REGEX_SEMESTER.search(line_str):
                    parsed_school_candidate.append(line_str)

        class_candidates = [
            c for c in parsed_school_candidate 
            if c != school_name and not REGEX_SESI.search(c)
        ]
        
        if class_candidates:
            class_name = class_candidates[-1]
        else:
            class_name = f"Unknown_Class_P{page_num}"
            logger.warning(f"Could not identify class name on page {page_num}. Defaulting to '{class_name}'.")
            self.stats["parsing_errors"] += 1

        self.stats["total_classes"] += 1
        logger.info(f"Page {page_num}: Parsing schedule for class '{class_name}' [Sesi: {session}, TA: {tahun_ajaran}, Sem: {semester}]")

        # 3. Detect row (period) headers
        period_candidates = []
        for word in words:
            if word["text"].isdigit() and word["x1"] < first_day_x0:
                period_candidates.append(word)
                
        if not period_candidates:
            logger.warning(f"No period headers found to the left of days on page {page_num}. Cannot parse grid.")
            self.stats["parsing_errors"] += 1
            return
            
        period_candidates_sorted = sorted(period_candidates, key=lambda w: w["top"])
        x0_counts = {}
        for w in period_candidates_sorted:
            rx0 = round(w["x0"])
            x0_counts[rx0] = x0_counts.get(rx0, 0) + 1
            
        best_x0 = max(x0_counts, key=x0_counts.get)
        period_elements = [w for w in period_candidates_sorted if abs(w["x0"] - best_x0) <= 8]
        period_elements.sort(key=lambda w: w["top"])
        max_period_x1 = max(w["x1"] for w in period_elements)

        # 4. Construct the Grid Coordinate System (using PDF lines if available)
        col_bounds = []
        row_bounds = []
        
        unique_v, unique_h = self._get_grid_lines(page)
        
        grid_success = False
        if unique_v and unique_h and len(unique_v) >= 6 and len(unique_h) >= 12:
            try:
                # Match day headers to vertical columns
                for day_w in day_elements:
                    cx = (day_w["x0"] + day_w["x1"]) / 2
                    left, right = None, None
                    for idx in range(len(unique_v) - 1):
                        v0 = unique_v[idx]
                        v1 = unique_v[idx+1]
                        if v0 <= cx <= v1:
                            left = v0
                            right = v1
                            break
                    if left is not None and right is not None:
                        col_bounds.append((left, right, day_w["text"]))
                        
                # Match period labels to horizontal rows
                for p_w in period_elements:
                    cy = (p_w["top"] + p_w["bottom"]) / 2
                    period_num = int(p_w["text"])
                    top, bottom = None, None
                    for idx in range(len(unique_h) - 1):
                        h0 = unique_h[idx]
                        h1 = unique_h[idx+1]
                        if h0 <= cy <= h1:
                            top = h0
                            bottom = h1
                            break
                    if top is not None and bottom is not None:
                        row_bounds.append((top, bottom, period_num))
                        
                if len(col_bounds) == len(day_elements) and len(row_bounds) == len(period_elements):
                    grid_success = True
                    logger.debug("Successfully aligned grid boundaries using vector lines.")
            except Exception as e:
                logger.debug(f"Failed to align grid using vector lines ({e}). Falling back to midpoint heuristics.")
                
        if not grid_success:
            col_bounds = []
            row_bounds = []
            
            # Midpoint heuristic for columns
            num_cols = len(day_elements)
            for i in range(num_cols):
                day_w = day_elements[i]
                if i == 0:
                    left = (max_period_x1 + day_w["x0"]) / 2
                else:
                    left = (day_elements[i-1]["x1"] + day_w["x0"]) / 2
                if i == num_cols - 1:
                    right = day_w["x1"] + (day_w["x1"] - day_w["x0"]) * 2
                else:
                    right = (day_w["x1"] + day_elements[i+1]["x0"]) / 2
                col_bounds.append((left, right, day_w["text"]))
                
            # Midpoint heuristic for rows
            num_rows = len(period_elements)
            for j in range(num_rows):
                p_w = period_elements[j]
                period_num = int(p_w["text"])
                if j == 0:
                    top = (header_bottom + p_w["top"]) / 2
                else:
                    top = (period_elements[j-1]["bottom"] + p_w["top"]) / 2
                if j == num_rows - 1:
                    bottom = p_w["bottom"] + (p_w["bottom"] - p_w["top"])
                else:
                    bottom = (p_w["bottom"] + period_elements[j+1]["top"]) / 2
                row_bounds.append((top, bottom, period_num))

        # 5. Extract cells for each day column (with vertical merging logic)
        for left, right, day_name in col_bounds:
            period_cells = []
            for top, bottom, period_num in row_bounds:
                cell_words = []
                for w in words:
                    cx = (w["x0"] + w["x1"]) / 2
                    cy = (w["top"] + w["bottom"]) / 2
                    if left <= cx <= right and top <= cy <= bottom:
                        cell_words.append(w)
                        
                cell_lines = group_words_into_lines(cell_words, tolerance=3.0)
                cell_lines = [line.strip() for line in cell_lines if line.strip()]
                
                period_cells.append({
                    "period": period_num,
                    "lines": cell_lines
                })
                
            buffer_lines = []
            buffer_periods = []
            
            for cell in period_cells:
                p_num = cell["period"]
                lines = cell["lines"]
                
                is_empty = (not lines) or (len(lines) == 1 and lines[0] == EMPTY_SLOT_INDICATOR)
                
                # Check if buffer has a teacher line
                buffer_has_teacher = False
                for line in buffer_lines:
                    if REGEX_TEACHER_CODE_NAME.match(line):
                        buffer_has_teacher = True
                        break
                        
                # Finalize buffer if:
                # - The current cell is empty
                # - OR the buffer already has a teacher and this cell is not empty
                if is_empty or (buffer_has_teacher and not is_empty):
                    if buffer_lines:
                        self._finalize_and_add_records(
                            buffer_lines, buffer_periods, day_name, class_name,
                            tahun_ajaran, semester, session
                        )
                        buffer_lines = []
                        buffer_periods = []
                        
                if is_empty:
                    self.stats["empty_slots"] += 1
                    logger.debug(f"Class '{class_name}', Day '{day_name}', Period '{p_num}' is empty/ignored.")
                    continue
                    
                # Add current cell's lines and period to buffer
                buffer_lines.extend(lines)
                buffer_periods.append(p_num)
                
            # Finalize any remaining buffer at the end of the day
            if buffer_lines:
                self._finalize_and_add_records(
                    buffer_lines, buffer_periods, day_name, class_name,
                    tahun_ajaran, semester, session
                )

    def save_outputs(self):
        """
        Saves the parsed records to Excel and CSV files.
        """
        if not self.records:
            logger.warning("No records parsed. Output files will not be created.")
            return

        df = pd.DataFrame(self.records)
        
        # Sort values logically: Class, Day index, Period
        day_order = {day: idx for idx, day in enumerate(KNOWN_DAYS)}
        df["_day_idx"] = df["Hari"].map(day_order).fillna(99)
        df = df.sort_values(by=["Kelas", "_day_idx", "Jam Ke"]).drop(columns=["_day_idx"])

        # Save to Excel
        try:
            df.to_excel(OUTPUT_EXCEL_PATH, index=False)
            logger.info(f"Excel file successfully saved to: {OUTPUT_EXCEL_PATH}")
        except Exception as e:
            logger.error(f"Failed to save Excel file to {OUTPUT_EXCEL_PATH}: {e}")
            self.stats["parsing_errors"] += 1

        # Save to CSV
        try:
            df.to_csv(OUTPUT_CSV_PATH, index=False, encoding="utf-8")
            logger.info(f"CSV file successfully saved to: {OUTPUT_CSV_PATH}")
        except Exception as e:
            logger.error(f"Failed to save CSV file to {OUTPUT_CSV_PATH}: {e}")
            self.stats["parsing_errors"] += 1

    def print_statistics(self):
        """
        Prints parser run statistics to the console.
        """
        stats_str = f"""
==================================================
              PARSING STATISTICS
==================================================
Jumlah Halaman            : {self.stats["total_pages"]}
Jumlah Kelas              : {self.stats["total_classes"]}
Jadwal Berhasil Diparse   : {self.stats["parsed_slots"]}
Jumlah Sel Kosong (ignored): {self.stats["empty_slots"]}
Jumlah Error / Warning    : {self.stats["parsing_errors"]}
==================================================
"""
        print(stats_str)
        logger.info("Statistics printed.")


def main():
    import glob
    from config import INPUT_DIR, OUTPUT_EXCEL_PATH, OUTPUT_CSV_PATH, OUTPUT_DIR
    
    # Find all PDFs in the input directory
    pdf_files = glob.glob(os.path.join(INPUT_DIR, "*.pdf"))
    
    # Filter out mock "jadwal.pdf" if actual ones exist
    actual_pdfs = [f for f in pdf_files if os.path.basename(f).lower() != "jadwal.pdf"]
    
    if actual_pdfs:
        pdf_to_process = actual_pdfs
        logger.info(f"Detected actual schedule PDFs to process: {[os.path.basename(f) for f in actual_pdfs]}")
    else:
        pdf_to_process = pdf_files
        logger.info("No actual schedule PDFs found. Processing all PDFs in input directory.")

    if not pdf_to_process:
        logger.error("No PDF files found in the input directory.")
        return

    combined_records = []
    total_stats = {
        "total_pages": 0,
        "total_classes": 0,
        "parsed_slots": 0,
        "empty_slots": 0,
        "parsing_errors": 0
    }

    target_columns = ["Sesi", "Kelas", "Hari", "Jam Ke", "Mata Pelajaran", "Guru", "Kode Guru"]
    day_order = {day: idx for idx, day in enumerate(KNOWN_DAYS)}

    for pdf_path in pdf_to_process:
        logger.info(f"--- Processing File: {os.path.basename(pdf_path)} ---")
        parser = FETScheduleParser(pdf_path)
        parser.parse()
        
        combined_records.extend(parser.records)
        for key in total_stats:
            total_stats[key] += parser.stats[key]
            
        # Save individual file outputs (matching the PDF filename)
        if parser.records:
            df_indiv = pd.DataFrame(parser.records)
            df_indiv["_day_idx"] = df_indiv["Hari"].map(day_order).fillna(99)
            df_indiv = df_indiv.sort_values(by=["Kelas", "_day_idx", "Jam Ke"]).drop(columns=["_day_idx"])
            df_indiv_target = df_indiv[target_columns]
            
            base_name = os.path.splitext(os.path.basename(pdf_path))[0]
            indiv_excel_path = os.path.join(OUTPUT_DIR, f"{base_name}.xlsx")
            indiv_csv_path = os.path.join(OUTPUT_DIR, f"{base_name}.csv")
            
            try:
                df_indiv_target.to_excel(indiv_excel_path, index=False)
                logger.info(f"Individual Excel successfully saved to: {indiv_excel_path}")
            except Exception as e:
                logger.error(f"Failed to save individual Excel {indiv_excel_path}: {e}")
                total_stats["parsing_errors"] += 1
                
            try:
                df_indiv_target.to_csv(indiv_csv_path, index=False, encoding="utf-8")
                logger.info(f"Individual CSV successfully saved to: {indiv_csv_path}")
            except Exception as e:
                logger.error(f"Failed to save individual CSV {indiv_csv_path} (ensure it is not open): {e}")
                total_stats["parsing_errors"] += 1

    # Save combined outputs
    if combined_records:
        df = pd.DataFrame(combined_records)
        df["_day_idx"] = df["Hari"].map(day_order).fillna(99)
        df = df.sort_values(by=["Kelas", "_day_idx", "Jam Ke"]).drop(columns=["_day_idx"])
        df_target = df[target_columns]

        # Save combined Excel
        try:
            df_target.to_excel(OUTPUT_EXCEL_PATH, index=False)
            logger.info(f"Combined Excel successfully saved to: {OUTPUT_EXCEL_PATH}")
        except Exception as e:
            logger.error(f"Failed to save combined Excel to {OUTPUT_EXCEL_PATH}: {e}")
            total_stats["parsing_errors"] += 1

        # Save combined CSV
        try:
            df_target.to_csv(OUTPUT_CSV_PATH, index=False, encoding="utf-8")
            logger.info(f"Combined CSV successfully saved to: {OUTPUT_CSV_PATH}")
        except Exception as e:
            logger.error(f"Failed to save combined CSV to {OUTPUT_CSV_PATH} (ensure it is not open): {e}")
            total_stats["parsing_errors"] += 1

        stats_str = f"""
==================================================
              COMBINED PARSING STATISTICS
==================================================
Jumlah File PDF           : {len(pdf_to_process)}
Jumlah Halaman            : {total_stats["total_pages"]}
Jumlah Kelas              : {total_stats["total_classes"]}
Jadwal Berhasil Diparse   : {total_stats["parsed_slots"]}
Jumlah Sel Kosong (ignored): {total_stats["empty_slots"]}
Jumlah Error / Warning    : {total_stats["parsing_errors"]}
==================================================
"""
        print(stats_str)
        logger.info("Combined statistics printed.")
    else:
        logger.warning("No records parsed from any files.")


if __name__ == "__main__":
    main()
