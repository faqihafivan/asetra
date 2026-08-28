import logging
import os
import sys
from typing import List, Dict, Any, Optional, Tuple
from config import LOG_FILE_PATH

def setup_logger() -> logging.Logger:
    """
    Sets up a logger that outputs to both a file and the console.
    """
    logger = logging.getLogger("FETParser")
    logger.setLevel(logging.DEBUG)
    
    # Avoid duplicate handlers if already set up
    if logger.handlers:
        return logger

    # Create formatters
    file_formatter = logging.Formatter(
        "[%(asctime)s] %(levelname)s [%(name)s:%(filename)s:%(lineno)d]: %(message)s",
        datefmt="%Y-%m-%d %H:%M:%S"
    )
    console_formatter = logging.Formatter("%(levelname)s: %(message)s")

    # File Handler
    try:
        # Ensure log directory exists
        log_dir = os.path.dirname(LOG_FILE_PATH)
        if log_dir:
            os.makedirs(log_dir, exist_ok=True)
            
        file_handler = logging.FileHandler(LOG_FILE_PATH, encoding="utf-8")
        file_handler.setLevel(logging.DEBUG)
        file_handler.setFormatter(file_formatter)
        logger.addHandler(file_handler)
    except Exception as e:
        print(f"Warning: Could not create log file at {LOG_FILE_PATH}. Error: {e}", file=sys.stderr)

    # Console Handler
    console_handler = logging.StreamHandler(sys.stdout)
    console_handler.setLevel(logging.INFO)
    console_handler.setFormatter(console_formatter)
    logger.addHandler(console_handler)

    return logger

# Initialize logger
logger = setup_logger()

def group_words_into_lines(words: List[Dict[str, Any]], tolerance: float = 3.0) -> List[str]:
    """
    Groups pdfplumber word objects horizontally into lines based on vertical overlap and top coordinate alignment.
    Sorts words inside each line from left to right.
    """
    if not words:
        return []
        
    # Sort words by top coordinate, then by left coordinate
    sorted_words = sorted(words, key=lambda w: (w["top"], w["x0"]))
    
    lines: List[List[Dict[str, Any]]] = []
    current_line: List[Dict[str, Any]] = []
    current_top = 0.0
    current_bottom = 0.0
    
    for word in sorted_words:
        w_top = float(word["top"])
        w_bottom = float(word["bottom"])
        
        if not current_line:
            current_line.append(word)
            current_top = w_top
            current_bottom = w_bottom
        else:
            # Calculate vertical overlap
            overlap = max(0.0, min(w_bottom, current_bottom) - max(w_top, current_top))
            height = min(w_bottom - w_top, current_bottom - current_top)
            
            # If vertical overlap is more than 30% of the character height,
            # or if the top coordinates are within the tolerance threshold
            if (height > 0 and overlap / height > 0.3) or abs(w_top - current_top) <= tolerance:
                current_line.append(word)
                # Expand vertical bounds of the line
                current_top = min(current_top, w_top)
                current_bottom = max(current_bottom, w_bottom)
            else:
                # Save previous line, sorted horizontally
                current_line.sort(key=lambda w: w["x0"])
                lines.append(current_line)
                
                # Start new line
                current_line = [word]
                current_top = w_top
                current_bottom = w_bottom
                
    if current_line:
        current_line.sort(key=lambda w: w["x0"])
        lines.append(current_line)
        
    # Convert lists of word dicts into strings
    text_lines = []
    for line_words in lines:
        line_text = " ".join([w["text"] for w in line_words])
        text_lines.append(line_text.strip())
        
    return text_lines

import re

def is_room_name(line: str) -> bool:
    """
    Checks if a line of text represents a room or classroom name.
    """
    line_lower = line.lower()
    # Common keywords for classrooms/rooms in school schedules
    room_keywords = ["lab", "teori", "ruang", "lapangan", "kelas", "aula", "bengkel", "r."]
    if any(kw in line_lower for kw in room_keywords):
        return True
    # If the line contains a number (rooms often contain numbers like R10, Teori 3)
    if re.search(r'\d', line):
        return True
    return False

def parse_cell_lines(
    lines: List[str], 
    teacher_regex: Any, 
    empty_indicator: str = "-x-"
) -> Optional[Dict[str, str]]:
    """
    Parses clean cell text lines into subject, teacher, teacher code, and room.
    Handles teacher name splitting across lines.
    Returns None if the cell matches empty criteria.
    """
    cleaned_lines = [line.strip() for line in lines if line.strip()]
    if not cleaned_lines:
        return None
        
    # If the cell is explicitly marked empty
    if len(cleaned_lines) == 1 and cleaned_lines[0] == empty_indicator:
        return None
        
    subject = ""
    teacher = ""
    teacher_code = ""
    room = ""
    
    # Look for a line containing the teacher code + name (e.g. "67 Jumran")
    teacher_line_idx = -1
    for idx, line in enumerate(cleaned_lines):
        match = teacher_regex.match(line)
        if match:
            teacher_line_idx = idx
            teacher_code = match.group(1)
            teacher = match.group(2).strip()
            
            # Look ahead for teacher name continuation on subsequent lines
            next_idx = idx + 1
            while next_idx < len(cleaned_lines):
                next_line = cleaned_lines[next_idx]
                if not is_room_name(next_line):
                    teacher += " " + next_line.strip()
                    next_idx += 1
                else:
                    break
            
            # Subject is all text before the teacher line
            subject = " ".join(cleaned_lines[:teacher_line_idx]).strip()
            # Room is all text after the teacher name continuation
            if next_idx < len(cleaned_lines):
                room = " ".join(cleaned_lines[next_idx:]).strip()
            break
            
    if teacher_line_idx == -1:
        # Fallback heuristic:
        # 1 line: Subject only
        # 2 lines: Subject (0), Teacher (1)
        # 3+ lines: Subject (0), Teacher (1), Room (2+)
        num_lines = len(cleaned_lines)
        if num_lines == 1:
            subject = cleaned_lines[0]
        elif num_lines == 2:
            subject = cleaned_lines[0]
            teacher = cleaned_lines[1]
        else:
            subject = cleaned_lines[0]
            teacher = cleaned_lines[1]
            room = " ".join(cleaned_lines[2:]).strip()
            
    return {
        "subject": subject,
        "teacher": teacher,
        "teacher_code": teacher_code,
        "room": room
    }
