import streamlit as st
import requests
import pandas as pd
import re
from reportlab.lib.pagesizes import letter, landscape
from reportlab.platypus import SimpleDocTemplate, Table, TableStyle, Paragraph, Spacer
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet
from io import BytesIO

# -------------------
# DEFAULT API SETTINGS
# -------------------

API_KEY = "{api}"  # Replace with a secure method to store API keys
URL = "https://openrouter.ai/api/v1/chat/completions"

# -------------------
# Streamlit App
# -------------------

st.set_page_config(page_title="Adaptive Learning Planner", page_icon="📚")
st.title("Adaptive Learning Planner")

# Collect user inputs
with st.form("learning_form"):
    st.header("Customize your Study Planner")

    learning_style = st.selectbox("Your Learning Style:", ["Visual", "Auditory", "Kinesthetic"])
    subject_difficulty = st.selectbox("Rate Subject Difficulty:", ["Easy", "Medium", "Hard"])
    energy_level = st.selectbox("Your Energy Level:", ["Low", "Medium", "High"])

    st.subheader("Subjects & Study Duration")
    
    subjects = []
    num_subjects = st.number_input("How many subjects do you have?", min_value=1, max_value=20, step=1)

    for i in range(num_subjects):
        subject = st.text_input(f"Subject {i+1} Name:", key=f"subject_{i}")
        duration = st.number_input(f"Hours for {subject if subject else 'Subject'}:", min_value=0.0, step=0.5, key=f"duration_{i}")
        subjects.append((subject, duration))

    extra_time = st.number_input("Hours needed for extra activities or play:", min_value=0.0, step=0.5)

    submitted = st.form_submit_button("🎯 Generate Study Plan")

if submitted:
    # Prompt preparation
    user_prompt = (
        f"You are an AI-powered study planner. Create an optimized daily study timetable based on "
        f"the following details:\n"
        f"- Learning Style: {learning_style}\n"
        f"- Subject Difficulty: {subject_difficulty}\n"
        f"- Energy Level: {energy_level}\n"
        f"- Subjects and Study Duration: {subjects}\n"
        f"- Extra/Play Time: {extra_time} hours\n"
        f"Provide the timetable in a structured table format with time slots. If possible, add a header row. "
        f"Return the table in plain text format."
    )

    # API headers
    headers = {
        "Authorization": f"Bearer {API_KEY}",
        "Content-Type": "application/json"
    }

    # API Payload
    data = {
        "model": "google/gemma-3-4b-it",
        "messages": [{"role": "user", "content": user_prompt}]
    }

    with st.spinner("⏳ Generating your personalized timetable..."):
        response = requests.post(URL, headers=headers, json=data)
    
    if response.status_code == 200:
        response_data = response.json()
        timetable_text = response_data.get("choices", [{}])[0].get("message", {}).get("content", "No timetable found")

        # Extract table lines
        table_lines = re.findall(r"\|.*\|", timetable_text)

        if table_lines:
            table_data = []
            for line in table_lines:
                row = [cell.strip() for cell in line.split("|") if cell.strip()]
                table_data.append(row)

            clean_table_data = [row for row in table_data if not all(re.fullmatch(r"[-–—]+", cell) for cell in row)]

            # Convert to DataFrame
            df = pd.DataFrame(clean_table_data[1:], columns=clean_table_data[0])

            st.success("✅ Here is your AI-generated study plan:")
            st.dataframe(df)

            # -----------------------
            # 📄 PDF GENERATION SECTION (LANDSCAPE)
            # -----------------------

            buffer = BytesIO()
            pdf = SimpleDocTemplate(buffer, pagesize=landscape(letter))  # <-- landscape mode
            elements = []

            styles = getSampleStyleSheet()

            # Title
            title = Paragraph("📚 Personalized Study Timetable", styles['Title'])
            elements.append(title)
            elements.append(Spacer(1, 12))

            # Prepare table data
            pdf_table_data = [list(df.columns)] + df.values.tolist()

            # Table
            table = Table(pdf_table_data, repeatRows=1)

            # Style
            table.setStyle(TableStyle([
                ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor("#336699")),
                ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
                ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
                ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
                ('FONTSIZE', (0, 0), (-1, 0), 12),
                ('FONTSIZE', (0, 1), (-1, -1), 10),
                ('BOTTOMPADDING', (0, 0), (-1, 0), 8),
                ('BACKGROUND', (0, 1), (-1, -1), colors.whitesmoke),
                ('GRID', (0, 0), (-1, -1), 0.5, colors.black),
            ]))

            elements.append(table)

            # Footer
            elements.append(Spacer(1, 20))
            footer = Paragraph("Generated by Adaptive Learning Planner | OpenAI powered", styles['Normal'])
            elements.append(footer)

            # Build PDF
            pdf.build(elements)
            pdf_data = buffer.getvalue()

            # Download Button
            st.download_button(
                label="⬇ Download Timetable (PDF)",
                data=pdf_data,
                file_name="study_timetable.pdf",
                mime="application/pdf"
            )

        else:
            st.warning("Could not extract a table. Here is the full response:")
            st.code(timetable_text)

    else:
        st.error(f"❌ Error {response.status_code}: {response.text}")
