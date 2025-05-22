<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>AI Predictions</title>
  <link rel="stylesheet" href="ai-style.css">
  <style>
    #chatbot {
      margin-top: 30px;
      width: 300px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 10px;
      background: #f9f9f9;
    }

    #chat-log {
      height: 200px;
      overflow-y: auto;
      margin-bottom: 10px;
      padding: 5px;
      border: 1px solid #ddd;
      background: #fff;
    }

    .bot-msg {
      color: blue;
    }

    .user-msg {
      color: green;
    }
  </style>
</head>

<body>
<h1>AI Predictions</h1>
<table border="1">
<tr><th>ID</th><th>AccidentID</th><th>Blood Type</th><th>Units</th><th>Confidence</th><th>Date</th></tr>
<tr><td>1</td><td>1</td><td>O-</td><td>2</td><td>0.95</td><td>2025-04-22</td></tr>
</table>

<!-- Chatbot Section -->
<div id="chatbot">
  <h2>Ask AI</h2>
  <div id="chat-log"></div>
  <input type="text" id="user-input" placeholder="Ask a question..." />
  <button onclick="handleChat()">Send</button>
</div>

<a href="index.php">Back</a>

<script>
  const responses = {
    //Core AI Questions
      "what is the confidence level": "The confidence level shows how certain the AI is about its prediction.",
  "how does ai predict blood needs": "It uses machine learning trained on past accidents, hospital data, and blood usage.",
  "who predicts this": "Our AI model makes these predictions based on real-world data patterns.",
  "can ai be wrong": "Yes, AI is not perfect. Predictions are suggestions and need medical review.",
  "how accurate is this ai": "It typically reaches over 90% confidence, depending on data quality.",
  "how does the system learn": "Through continuous training on updated hospital and accident datasets.",
  "can the ai predict rare blood types": "Yes, but predictions are more accurate for common blood types.",
  "how is confidence calculated": "It's based on statistical certainty using model probabilities.",
  "does ai consider patient age": "Yes, age is one of the factors that can influence blood need.",
  "can it predict based on accident type": "Absolutely. The severity and type of accident help shape the prediction.",
  "how often is the ai updated": "Regularly, based on new data from hospitals and blood banks.",
  "is the ai self-learning": "It’s updated manually for now, but future versions will learn automatically.",
  "can the model detect unusual patterns": "Yes, it can identify anomalies in accident or blood usage data.",
  "what happens if data is missing": "AI may still predict, but with lower confidence.",
  "does ai compare with past accidents": "Yes, historical accident cases help build context for new predictions.",
  "can ai predict how long blood will last": "No, but it focuses on how much is needed now based on urgency.",
  "how many cases can ai handle": "It can process multiple accident cases simultaneously.",
  "what is a prediction id": "It's a unique identifier for each prediction made by the system.",
  "what if multiple patients are involved": "AI will estimate total units required based on inputs.",
  "can this be used across cities": "Yes, predictions work across all registered accident locations.",
  "what does low confidence mean": "Low confidence means the AI is unsure—manual review is recommended.",
  "is there human supervision": "Yes, doctors and admins can override AI suggestions.",
  "does ai know blood inventory": "Yes, it cross-checks blood stock before recommending units.",
  "can this help rural hospitals": "Yes, AI fills in medical decision gaps where expertise is limited.",
  "how fast are predictions made": "Within seconds of submitting the data."
  //Blood Donation and Transfusion
    "what is a blood unit": "One unit equals around 450 ml of donated blood.",
  "what is o- blood": "O negative is a universal red blood cell donor type.",
  "what blood type is most needed": "O- and A+ are often in highest demand for emergencies.",
  "what is a universal donor": "People with O- blood can donate to almost everyone.",
  "how often can i donate": "Every 3 months for men, 4 months for women.",
  "who can receive ab+ blood": "AB+ patients can receive blood from any group.",
  "is there a universal plasma donor": "Yes, AB blood type is a universal plasma donor.",
  "how do blood transfusions work": "Blood is matched and transferred into the patient’s vein.",
  "what if the wrong blood is given": "It can cause serious complications or death. That’s why prediction is critical.",
  "how long does donated blood last": "Stored red blood cells last about 42 days.",
  "what are platelets": "Platelets help blood clot and are also donated.",
  "can i donate if i had covid": "Yes, after full recovery and meeting other health criteria.",
  "can ai predict platelets need": "This version focuses on red cell demand, not platelets yet.",
  "what if rare blood is needed": "The system alerts nearby centers that might stock rare types.",
  "what's rh factor": "It’s a protein on red blood cells—positive or negative.",
  "can ai handle mass casualty events": "Yes, it's built to scale for large events with multiple injuries.",
  "what is crossmatching": "It’s a lab test to ensure compatibility before transfusion.",
  "how do you store blood": "In blood banks, at controlled temperatures to prevent spoilage.",
  "why is blood donation important": "It saves lives in emergencies, surgeries, and chronic illness cases.",
  "how many people need blood daily": "Thousands of people across the country need blood each day.",
  "can you donate if you have tattoos": "Yes, after a waiting period depending on local rules.",
  "is blood donation painful": "Just a pinch! Most people find it easy and quick.",
  "how do i become a donor": "Go to the Donor section and fill out the registration form.",
  "can i donate if i'm under 18": "You must be at least 18 in most areas to donate.",
  "what if i feel dizzy after donating": "It’s normal—rest, hydrate, and you’ll be fine soon."
//Medical and Emergency 
  "what is accident id": "It links each prediction to a specific accident event.",
  "can ai detect an emergency": "It reacts when emergency data is entered by staff.",
  "how does ai help ambulances": "They can input data on the go and get instant blood needs.",
  "can ai tell which hospital to send data to": "Yes, based on accident location and hospital availability.",
  "what if more blood is needed later": "The system can make secondary predictions as new info arrives.",
  "can this work without internet": "No, the system needs live data connection to function.",
  "what if power goes out": "Offline backups and manual alerts are recommended.",
  "does it work during disasters": "Yes, the system is designed for emergency use cases.",
  "can ai handle traffic accident reports": "Yes, it processes all types of accidents including road incidents.",
  "what if a hospital disagrees with ai": "Doctors can override AI if they think it's incorrect.",
  "can ai integrate with hospital software": "Yes, through API or manual form uploads.",
  "can hospitals see all predictions": "They only see relevant ones for their location or assigned zone.",
  "how are predictions verified": "Through follow-up data after actual transfusions.",
  "how many predictions per day": "The system can handle hundreds depending on server capacity.",
  "does it work in remote areas": "Yes, with internet and mobile access, it works anywhere.",
  "what if wrong data is submitted": "Predictions may be off—admins can edit or resubmit cases.",
  "how is patient privacy protected": "Only anonymized data is used for predictions.",
  "how does ai respond to changes": "If accident data is updated, AI generates a new prediction.",
  "what if two accidents happen at once": "AI handles them separately with unique predictions.",
  "what does the date column mean": "It shows when the AI made the prediction.",
  "can ai prioritize cases": "Yes, it uses urgency, severity, and time to prioritize.",
  "what if inventory is too low": "The system sends an emergency alert to nearby blood banks.",
  "does ai support pediatric cases": "Currently, it works best with adult cases; pediatric logic is under development.",
  "can this save lives": "Absolutely. Faster prediction and response time save critical minutes.",
  "is this used in real hospitals": "Yes, or it can be easily adopted with slight integration steps."
//System Use , UI , General Questions
  "what is this page about": "This page shows predictions made by AI for blood needs in accidents.",
  "how do i use this page": "View the table or ask the AI about anything related to predictions.",
  "can i ask questions here": "Yes! Type your question below and the chatbot will help.",
  "how do i go back": "Click the 'Back' link at the bottom to return to the home page.",
  "can i clear the chat": "Just refresh the page to reset the chat.",
  "can this run on mobile": "Yes, it’s mobile-friendly and responsive.",
  "how to read the table": "Each row shows an AI prediction linked to an accident.",
  "what is the table id": "It’s just a reference number for tracking each entry.",
  "what if nothing shows in table": "There may be no data, or a connection issue. Contact admin.",
  "what language is this built in": "This tool is built using PHP, JS, HTML, and MySQL.",
  "can i export predictions": "That feature is coming soon. Stay tuned!",
  "how to contact support": "Go to the Contact page from the menu for help.",
  "what is the chatbot for": "To help you understand AI predictions and the system better.",
  "does this work offline": "No, internet is required for predictions and chat responses.",
  "can i update predictions": "Admins can update prediction data via the control panel.",
  "can students use this for study": "Yes, this tool is useful for medical and tech learners.",
  "can i integrate this into my hospital": "Yes, with a few steps you can link your hospital system.",
  "is there a dark mode": "Yes! Check the settings to enable dark theme.",
  "how do i log in": "Use the login page and select your role to sign in.",
  "can i trust the ai": "It’s built for accuracy but always consult a doctor.",
  "what happens after prediction": "Hospitals are notified and can begin preparations.",
  "what if my question isn’t answered": "Try rephrasing or contact support for assistance.",
  "can i submit feedback": "Yes! We appreciate your feedback to improve this system.",
  "can i share this tool": "Yes, share the link with hospitals or donors.",
  "who developed this system": "It’s part of the Blood Bank Management Project by our tech team."
  };

  function handleChat() {
    const input = document.getElementById("user-input").value.trim().toLowerCase();
    const log = document.getElementById("chat-log");
    if (!input) return;
    log.innerHTML += `<div class="user-msg"><strong>You:</strong> ${input}</div>`;
    const response = responses[input] || "Sorry, I don't understand that. Try asking something else.";
    log.innerHTML += `<div class="bot-msg"><strong>AI:</strong> ${response}</div>`;
    document.getElementById("user-input").value = "";
    log.scrollTop = log.scrollHeight;
  }
</script>
<script src="js/app.js"></script>
</body>
</html>
<!-- End of AI Predictions Page -->