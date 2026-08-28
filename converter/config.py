import os
import re

# Directory Paths
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
INPUT_DIR = os.path.join(BASE_DIR, "input")
OUTPUT_DIR = os.path.join(BASE_DIR, "output")

# Ensure directories exist
os.makedirs(INPUT_DIR, exist_ok=True)
os.makedirs(OUTPUT_DIR, exist_ok=True)

# Default Values (if not found in PDF)
DEFAULT_SCHOOL = "SMK NEGERI 3 PALU"
DEFAULT_TAHUN_AJARAN = "2026/2027"
DEFAULT_SEMESTER = "Ganjil"
DEFAULT_SESI = "A"

# Input/Output Files
INPUT_PDF_PATH = os.path.join(INPUT_DIR, "jadwal.pdf")
OUTPUT_EXCEL_PATH = os.path.join(OUTPUT_DIR, "jadwal_import.xlsx")
OUTPUT_CSV_PATH = os.path.join(OUTPUT_DIR, "jadwal_import.csv")
LOG_FILE_PATH = os.path.join(OUTPUT_DIR, "parsing.log")

# Schedule Layout Config
KNOWN_DAYS = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"]

# Regular Expressions for Parsing
# Matches teacher code and name (e.g., "67 Jumran" or "70 Leonard Randanan")
# Group 1: Code (digits), Group 2: Name (text)
REGEX_TEACHER_CODE_NAME = re.compile(r"^\s*(\d+)\s+(.+)$")

# Matches session in top section (e.g., "(SESI A)" or "(Sesi A)")
REGEX_SESI = re.compile(r"\((?:SESI|Sesi)\s*(?:-\s*)?([A-Za-z0-9]+)\)", re.IGNORECASE)

# Matches academic year in text (e.g., "2026/2027")
REGEX_TAHUN_AJARAN = re.compile(r"(\d{4}/\d{4})")

# Matches semester in text (e.g., "Ganjil" or "Genap")
REGEX_SEMESTER = re.compile(r"(Ganjil|Genap)", re.IGNORECASE)

# Words indicating empty slots that should be ignored
EMPTY_SLOT_INDICATOR = "-x-"
