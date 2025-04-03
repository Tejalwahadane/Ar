import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
import joblib

# Load dataset
df = pd.read_csv("crop_data.csv")

# Features and target
X = df.drop(columns=["label"])  # All columns except crop name
y = df["label"]  # Crop name

# Split data (80% train, 20% test)
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train the model
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# Save the trained model
joblib.dump(model, "crop_recommendation_model.pkl")

print("Model trained and saved successfully!")
