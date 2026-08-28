import os
from reportlab.lib.pagesizes import letter
from reportlab.lib import colors
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from config import INPUT_PDF_PATH

def generate_mock_pdf():
    # Ensure directory exists
    os.makedirs(os.path.dirname(INPUT_PDF_PATH), exist_ok=True)

    # Document setup
    doc = SimpleDocTemplate(
        INPUT_PDF_PATH,
        pagesize=letter,
        rightMargin=36,
        leftMargin=36,
        topMargin=36,
        bottomMargin=36
    )

    styles = getSampleStyleSheet()
    
    # Custom styles
    title_style = ParagraphStyle(
        'SchoolTitle',
        parent=styles['Heading1'],
        fontName='Helvetica-Bold',
        fontSize=14,
        alignment=1,  # Center
        spaceAfter=2
    )
    session_style = ParagraphStyle(
        'SessionSubtitle',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=11,
        alignment=1,  # Center
        spaceAfter=8
    )
    class_style = ParagraphStyle(
        'ClassTitle',
        parent=styles['Heading2'],
        fontName='Helvetica-Bold',
        fontSize=12,
        alignment=1,  # Center
        spaceAfter=12
    )
    header_style = ParagraphStyle(
        'HeaderStyle',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=9,
        alignment=1,  # Center
        leading=11,
        textColor=colors.whitesmoke
    )
    cell_style = ParagraphStyle(
        'CellStyle',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8,
        alignment=1,  # Center
        leading=9
    )

    # Days list (columns)
    days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"]
    headers = [Paragraph("Jam", header_style)] + [Paragraph(day, header_style) for day in days]

    story = []

    # Page 1: X PPLG A
    # Top titles
    story.append(Paragraph("SMK NEGERI 3 PALU", title_style))
    story.append(Paragraph("(SESI A)", session_style))
    story.append(Paragraph("X PPLG A", class_style))

    # Grid data setup (11 periods)
    grid_data_1 = [headers]
    for period in range(1, 12):
        row = [Paragraph(str(period), cell_style)]
        
        # Populate each day for this period
        for day_idx in range(5):
            # Monday (Senin)
            if day_idx == 0:
                if period == 1:
                    cell_text = "Bahasa Indonesia<br/>67 Jumran<br/>Teori 1"
                elif period == 2:
                    cell_text = "Matematika<br/>70 Leonard Randanan<br/>Lab 2"
                elif period in [3, 4]:
                    cell_text = "Dasar PPLG<br/>15 Ahmad Fauzi"
                elif period == 5:
                    cell_text = "-x-"
                elif period in [6, 7]:
                    cell_text = "Pendidikan Pancasila<br/>08 Asriani"
                else:
                    cell_text = "-x-"
            # Tuesday (Selasa)
            elif day_idx == 1:
                if period in [1, 2]:
                    cell_text = "Bahasa Inggris<br/>34 Sarah Smith<br/>Teori 2"
                elif period in [3, 4, 5]:
                    cell_text = "Kejuruan PPLG<br/>45 Wahyu Hidayat<br/>Lab 1"
                elif period == 6:
                    cell_text = ""  # Completely empty cell
                elif period in [7, 8]:
                    cell_text = "Pendidikan Agama<br/>12 Syarifuddin"
                else:
                    cell_text = "-x-"
            # Wednesday (Rabu)
            elif day_idx == 2:
                if period in [1, 2, 3]:
                    cell_text = "Kejuruan PPLG<br/>45 Wahyu Hidayat<br/>Lab 1"
                elif period in [4, 5]:
                    cell_text = "Sejarah<br/>20 Hartono"
                elif period in [6, 7]:
                    cell_text = "Penjasorkes<br/>11 Budi Santoso<br/>Lapangan"
                else:
                    cell_text = "-x-"
            # Thursday (Kamis)
            elif day_idx == 3:
                if period in [1, 2]:
                    cell_text = "Seni Budaya<br/>05 Eka Saputra"
                elif period in [3, 4, 5]:
                    cell_text = "Informatika<br/>22 Rina Wati<br/>Lab 3"
                elif period in [6, 7, 8]:
                    cell_text = "Kejuruan PPLG<br/>99 Fahrul"
                else:
                    cell_text = "-x-"
            # Friday (Jumat)
            else:
                if period in [1, 2, 3]:
                    # Teacher with no code (fallback test)
                    cell_text = "Bimbingan Konseling<br/>Nurdin"
                elif period in [4, 5]:
                    cell_text = "Projek IPAS<br/>18 Dewi Lestari"
                else:
                    cell_text = "-x-"
                    
            row.append(Paragraph(cell_text, cell_style))
        grid_data_1.append(row)

    # Make table
    col_widths = [40, 100, 100, 100, 100, 100]
    table_1 = Table(grid_data_1, colWidths=col_widths)
    table_1.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor("#1A365D")),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('VALIGN', (0, 0), (-1, -1), 'MIDDLE'),
        ('GRID', (0, 0), (-1, -1), 0.5, colors.grey),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 6),
        ('TOPPADDING', (0, 0), (-1, -1), 6),
    ]))
    
    story.append(table_1)
    story.append(PageBreak())

    # Page 2: XI PPLG B
    story.append(Paragraph("SMK NEGERI 3 PALU", title_style))
    story.append(Paragraph("(SESI A)", session_style))
    story.append(Paragraph("XI PPLG B", class_style))

    # Grid data setup (11 periods)
    grid_data_2 = [headers]
    for period in range(1, 12):
        row = [Paragraph(str(period), cell_style)]
        
        # Populate each day for this period
        for day_idx in range(5):
            # Monday (Senin)
            if day_idx == 0:
                if period in [1, 2, 3]:
                    cell_text = "Matematika Tingkat Lanjut<br/>70 Leonard Randanan<br/>Teori 3"
                elif period in [4, 5]:
                    cell_text = "Bahasa Indonesia<br/>67 Jumran"
                else:
                    cell_text = "-x-"
            # Tuesday (Selasa)
            elif day_idx == 1:
                if period in [1, 2, 3, 4]:
                    cell_text = "Web Frameworks<br/>45 Wahyu Hidayat<br/>Lab 1"
                elif period in [5, 6]:
                    cell_text = "Bahasa Inggris<br/>34 Sarah Smith"
                else:
                    cell_text = "-x-"
            # Wednesday (Rabu)
            elif day_idx == 2:
                if period in [1, 2, 3, 4]:
                    cell_text = "Database Management<br/>22 Rina Wati<br/>Lab 3"
                elif period in [5, 6, 7]:
                    cell_text = "Kewirausahaan<br/>55 Hendra Wijaya"
                else:
                    cell_text = "-x-"
            # Thursday (Kamis)
            elif day_idx == 3:
                if period in [1, 2, 3, 4, 5]:
                    cell_text = "Mobile Development<br/>99 Fahrul<br/>Lab 2"
                else:
                    cell_text = "-x-"
            # Friday (Jumat)
            else:
                if period in [1, 2, 3]:
                    cell_text = "Pendidikan Agama<br/>12 Syarifuddin"
                elif period in [4, 5]:
                    cell_text = "PKn<br/>08 Asriani"
                else:
                    cell_text = "-x-"
                    
            row.append(Paragraph(cell_text, cell_style))
        grid_data_2.append(row)

    # Make table 2
    table_2 = Table(grid_data_2, colWidths=col_widths)
    table_2.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor("#1A365D")),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('VALIGN', (0, 0), (-1, -1), 'MIDDLE'),
        ('GRID', (0, 0), (-1, -1), 0.5, colors.grey),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 6),
        ('TOPPADDING', (0, 0), (-1, -1), 6),
    ]))
    
    story.append(table_2)

    # Build PDF
    doc.build(story)
    print(f"Mock PDF successfully generated at: {INPUT_PDF_PATH}")

if __name__ == "__main__":
    generate_mock_pdf()
