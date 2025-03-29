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


conn.commit()

# Fetch data
cursor.execute("SELECT id, entry, family_relationship FROM weekly_journal")
rows = cursor.fetchall()

# Load the emotion analysis model
model_name = "j-hartmann/emotion-english-distilroberta-base"
tokenizer = AutoTokenizer.from_pretrained(model_name)
model = AutoModelForSequenceClassification.from_pretrained(model_name)

# Emotion labels (based on the model's output)
emotion_labels = ["anger", "disgust", "fear", "joy", "neutral", "sadness", "surprise"]

def predict_emotion(text):
    if not text:
        return "No text provided"
    
    inputs = tokenizer(text, return_tensors="pt", truncation=True, padding=True)
    outputs = model(**inputs)
    probs = torch.nn.functional.softmax(outputs.logits, dim=-1)
    
    # Get the predicted emotion
    predicted_label = emotion_labels[torch.argmax(probs).item()]
    return predicted_label

# Process each entry and update the database
for row in rows:
    entry_id, entry_text, family_text = row
    entry_emotion = predict_emotion(entry_text)
    family_emotion = predict_emotion(family_text)
    
    # Save emotions into MySQL
    update_query = """
        UPDATE weekly_journal 
        SET entry_emotion = %s, family_emotion = %s 
        WHERE id = %s
    """
    cursor.execute(update_query, (entry_emotion, family_emotion, entry_id))
    conn.commit()

    print(f"Updated ID {entry_id}: Entry Emotion = {entry_emotion}, Family Emotion = {family_emotion}")

# Close connection
cursor.close()
conn.close()
