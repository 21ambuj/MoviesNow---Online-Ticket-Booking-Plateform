from flask import Flask, request
import requests
from flask_cors import CORS  # ✅ To allow PHP to talk to Flask

app = Flask(__name__)
CORS(app)  # 🔓 Allow access from your PHP frontend

GROQ_API_KEY = "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"

def get_response_from_groq(user_input):
    headers = {
        "Authorization": f"Bearer {GROQ_API_KEY}",
        "Content-Type": "application/json"
    }

    data = {
        "messages": [
            {"role": "system", "content": "You are a helpful assistant that helps users with networking assistance like connecting people, making good connections."},
            {"role": "user", "content": user_input}
        ],
        "model": "llama3-8b-8192",
    }

    response = requests.post("https://api.groq.com/openai/v1/chat/completions", headers=headers, json=data)
    return response.json()['choices'][0]['message']['content']

@app.route("/get", methods=["GET"])
def get_bot_response():
    user_input = request.args.get("msg")
    return get_response_from_groq(user_input)

if __name__ == "__main__":
    app.run(debug=True)
