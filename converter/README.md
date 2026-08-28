# FET PDF Schedule to Tabular Excel/CSV Converter

A modular Python tool to parse school schedules exported from **FET (Free Timetabling Software)** in PDF format and convert them into a flat (long-format) Excel (`.xlsx`) and CSV (`.csv`) table. The output is structured to be immediately ready for database import (e.g., in a Laravel-based school information system).

---

## Features

- **No OCR required**: Relies on direct coordinate-based text extraction using `pdfplumber`.
- **Coordinate-based Alignment**: Dynamically detects column coordinates based on day headers (`Senin`, `Selasa`, etc.) and row coordinates based on period numbers (`1`, `2`, ..., `11`).
- **Flexible Cell Parsing**: Extracts Subject, Teacher Code (numeric), Teacher Name, and Room (optional) from multi-line cells using custom heuristics and Regular Expressions.
- **Robust Validations**: Automatically logs warning/info alerts for empty slots or cases where a teacher name is not found for a subject.
- **Console Progress Bar**: Uses `tqdm` to display execution progress when handling multi-page schedule documents.
- **Log Archiving**: Writes detailed tracing, warning, and error messages to `converter/output/parsing.log`.
- **Parsing Statistics**: Displays a neat summary of parsed pages, classes, slots, empty cells, and warning counts.

---

## Directory Structure

```
converter/
├── .venv/                 # Python virtual environment (auto-created)
├── input/
│   └── jadwal.pdf         # Place your input FET PDF schedule here
├── output/
│   ├── jadwal_import.xlsx # Flat Excel file for Laravel import
│   ├── jadwal_import.csv  # Flat CSV file
│   └── parsing.log        # Detailed runtime log
├── config.py              # Parser configurations (defaults, regexes, days)
├── utils.py               # Logger, horizontal line-grouper, cell parse helpers
├── parser.py              # Main pipeline orchestrator and parser
├── generate_mock_pdf.py   # Test utility to generate a mock FET PDF schedule
└── requirements.txt       # Project python dependencies
```

---

## Installation & Setup

We recommend using `uv` (a fast Python package installer and resolver) to manage dependencies. If `uv` is installed, follow these commands:

1. **Open your terminal** and navigate to the `converter` folder:
   ```powershell
   cd converter
   ```

2. **Initialize a Virtual Environment**:
   ```powershell
   uv venv
   ```

3. **Install Dependencies**:
   ```powershell
   uv pip install -r requirements.txt
   ```

*(Alternatively, you can use standard Python: `python -m venv .venv`, activate it with `.venv\Scripts\activate` on Windows or `source .venv/bin/activate` on macOS/Linux, and run `pip install -r requirements.txt`.)*

---

## How to Run

### 1. Generating Mock Test PDF
Since the PDF schedule contains custom classes, teachers, and rooms, you can run the mock PDF generator to create a sample `jadwal.pdf` in the `input` directory:
```powershell
uv run python generate_mock_pdf.py
```
This generates a two-page test PDF for classes `X PPLG A` and `XI PPLG B` with varying subjects, teacher codes, names, and rooms, including empty cells (`-x-` and blank).

### 2. Running the Parser
Ensure your target PDF is located at `converter/input/jadwal.pdf`. Then, run the parser:
```powershell
uv run python parser.py
```
The program will print a progress bar, execute coordinate-based cell grouping, write outputs to the `output/` directory, and print statistics like:

```text
==================================================
              PARSING STATISTICS
==================================================
Jumlah Halaman            : 2
Jumlah Kelas              : 2
Jadwal Berhasil Diparse   : 32
Jumlah Sel Kosong (ignored): 78
Jumlah Error / Warning    : 2
==================================================
```

---

## Flat Output Format Schema

The generated files (`jadwal_import.xlsx` and `jadwal_import.csv`) contain the following columns:

| Column Name | Description | Example |
| :--- | :--- | :--- |
| **Tahun Ajaran** | School academic year (extracted from PDF or default) | `2026/2027` |
| **Semester** | Semester name (extracted from PDF or default) | `Ganjil` |
| **Sesi** | School session (extracted from top header, e.g. `(SESI A)`) | `A` |
| **Kelas** | Class name (extracted from top header) | `X PPLG A` |
| **Hari** | Day of the week | `Senin` |
| **Jam Ke** | Period number | `1` |
| **Mata Pelajaran** | Subject name | `Bahasa Indonesia` |
| **Guru** | Teacher name | `Jumran` |
| **Kode Guru** | Unique teacher ID (numeric digits) | `67` |
| **Ruang** | Room name (optional) | `Teori 1` |

---

## Customization & Configuration

You can easily customize the parser's behavior in [config.py](file:///e:/projek%208%20m/asetra/converter/config.py):
- **Defaults**: Modify `DEFAULT_SCHOOL`, `DEFAULT_TAHUN_AJARAN`, `DEFAULT_SEMESTER` or `DEFAULT_SESI`.
- **Day names**: If your FET schedule uses English or other day names, update the `KNOWN_DAYS` list.
- **Regular Expressions**:
  - `REGEX_TEACHER_CODE_NAME`: Tweak this if the teacher format in cells is different (e.g. name before code).
  - `REGEX_SESI`: Modify this if sessions are represented differently in the headers.
  - `REGEX_TAHUN_AJARAN` / `REGEX_SEMESTER`: Modify to match different academic calendar names.
