import mysql.connector
import pandas as pd

# Connect to MySQL Database
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="kisansetu"
)
cursor = conn.cursor(dictionary=True)

# Fetch all farmer data
cursor.execute("SELECT * FROM farmers")
farmers = cursor.fetchall()

# Convert data to Pandas DataFrame
df = pd.DataFrame(farmers)

# Priority Score Calculation
df["priority_score"] = (
    100 - (5 * df["previous_enrollments"]) - (df["income"] / 20000)
    + (10 * df["crop_losses"]) + (15 * df["debt_status"]) - (5 * df["land_size"])
)

# Sort Farmers by Priority (Higher score first)
df = df.sort_values(by="priority_score", ascending=False)

# ✅ **Auto-Approve Top 100 Farmers**
df["approved"] = 0  # Default: Not approved
df.loc[df.index[:100], "approved"] = 1  # Approve top 100

# ✅ **Update priority_score & approval status in database**
for index, row in df.iterrows():
    cursor.execute(
        "UPDATE farmers SET priority_score = %s, approved = %s WHERE aadhaar = %s",
        (row["priority_score"], row["approved"], row["aadhaar"])
    )

# Commit changes & close connection
conn.commit()
conn.close()

print("\n✅ Farmers' priority scores updated and top 100 farmers auto-approved!")