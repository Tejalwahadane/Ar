import sys
import joblib
import numpy as np
import pandas as pd  # Import pandas

# Load trained model
model = joblib.load("crop_recommendation_model.pkl")

# Read input parameters
N, P, K, temperature, humidity, ph, rainfall = map(float, sys.argv[1:])

# Make prediction
input_features = pd.DataFrame([[N, P, K, temperature, humidity, ph, rainfall]], 
                              columns=['N', 'P', 'K', 'temperature', 'humidity', 'ph', 'rainfall'])

predicted_crop = model.predict(input_features)[0]

print(predicted_crop)
