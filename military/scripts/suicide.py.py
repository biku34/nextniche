import mysql.connector
from transformers import AutoTokenizer, AutoModelForSequenceClassification
import torch

# Connect to MySQL
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="manoraksha"
)
cursor = conn.cursor()

# Fetch data (including family_relationship column)
cursor.execute("SELECT id, entry, family_relationship FROM weekly_journal")
rows = cursor.fetchall()

# Load the model
model_name = "sentinet/suicidality"
tokenizer = AutoTokenizer.from_pretrained(model_name)
model = AutoModelForSequenceClassification.from_pretrained(model_name)

def predict_suicidal_tendency(text):
    inputs = tokenizer(text, return_tensors="pt", truncation=True, padding=True)
    outputs = model(**inputs)
    probs = torch.nn.functional.softmax(outputs.logits, dim=-1)
    return probs[0][1].item()*100 # Assuming index 1 corresponds to suicidal intent

# Process each entry and update the database
for row in rows:
    entry_id, entry_text, family_text = row
    entry_score = predict_suicidal_tendency(entry_text) if entry_text else 0.0
    family_score = predict_suicidal_tendency(family_text) if family_text else 0.0
    
    # Save the scores back into the database
    update_query = """
        UPDATE weekly_journal 
        SET entry_score = %s, family_score = %s 
        WHERE id = %s
    """
    cursor.execute(update_query, (entry_score, family_score, entry_id))
    conn.commit()

    print(f"Updated ID {entry_id}: Entry Score = {entry_score:.4f}, Family Score = {family_score:.4f}")

# Close connection
cursor.close()
conn.close()
