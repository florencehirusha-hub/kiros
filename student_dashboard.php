<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kairos AI</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            navy: "#0B1F3A",
            navySoft: "#1E3A8A",
            blueAccent: "#3B82F6",
            blueLight: "#93C5FD",
            blueBg: "#EFF6FF",
            pageBg: "#F8FAFC"
          }
        }
      }
    }
  </script>

  <style>
    .card-hover:hover {
      transform: translateY(-6px) scale(1.02);
      transition: 0.3s ease;
    }

    .btn-glow:hover {
      box-shadow: 0 0 20px rgba(59,130,246,0.45);
      transition: 0.3s ease;
    }

    .nav-item {
      transition: 0.25s ease;
    }

    .nav-item:hover {
      transform: translateX(6px);
    }

    .logo {
      animation: float 3s ease-in-out infinite, glow 2.5s ease-in-out infinite;
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.1) rotate(3deg);
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-6px); }
      100% { transform: translateY(0px); }
    }

    @keyframes glow {
      0% { filter: drop-shadow(0 0 5px rgba(59,130,246,0.35)); }
      50% { filter: drop-shadow(0 0 14px rgba(59,130,246,0.75)); }
      100% { filter: drop-shadow(0 0 5px rgba(59,130,246,0.35)); }
    }

    .hidden-section {
      display: none;
    }

    .survey-option:hover {
      background: #f8fbff;
      border-color: #93C5FD;
    }
  </style>
</head>

<body class="bg-pageBg">
  <div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <div class="w-72 bg-navy text-white flex flex-col p-6 justify-between animate__animated animate__fadeInLeft shadow-xl">
      <div>
        <div class="mb-12 flex items-center gap-4">
          <img
            src="delta-strix-logo.png"
            alt="Kairos Logo"
            class="logo w-14 h-14 object-contain bg-white rounded-md p-1"
          />
          <div>
            <h1 class="text-3xl font-bold leading-none">Kairos</h1>
            <p class="text-sm text-blueLight mt-1">by Delta Strix</p>
          </div>
        </div>

        <div class="space-y-3">
          <div class="nav-item flex items-center gap-3 p-4 rounded-xl bg-[#29459D] text-white font-medium">
            <i data-lucide="house"></i> Home
          </div>

          <div class="nav-item flex items-center gap-3 p-4 rounded-xl text-blueLight hover:bg-[#102A54]">
            <i data-lucide="bar-chart-3"></i> Results
          </div>

          <div class="nav-item flex items-center gap-3 p-4 rounded-xl text-blueLight hover:bg-[#102A54]">
            <i data-lucide="file-text"></i> Your Dashboard
          </div>

          <div class="nav-item flex items-center gap-3 p-4 rounded-xl text-blueLight hover:bg-[#102A54]">
            <i data-lucide="book-open"></i> Research
          </div>

          <div class="nav-item flex items-center gap-3 p-4 rounded-xl text-blueLight hover:bg-[#102A54]">
            <i data-lucide="clock-3"></i> Progress
          </div>
        </div>
      </div>

      <div class="text-blueLight text-sm flex items-center gap-3 p-2">
        <i data-lucide="bookmark"></i> Saved Careers
      </div>
    </div>

    <!-- MAIN -->
    <div class="flex-1 p-10 overflow-y-auto">

      <!-- DASHBOARD CONTENT -->
      <div id="dashboardContent">
        <div class="animate__animated animate__fadeInUp mb-8">
          <h1 class="text-5xl font-bold text-navy mb-4 leading-tight">
            Discover Your Future Career
          </h1>
          <p class="text-gray-500 max-w-3xl text-lg leading-relaxed">
            Answer a short guided survey and let Kairos understand your passions,
            strengths, interests, and future potential.
          </p>
        </div>

        <div class="animate__animated animate__fadeInUp animate__delay-1s mb-6">
          <div class="bg-gradient-to-r from-[#eaf2ff] to-[#f4f8ff] border border-blue-100 rounded-2xl px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-sm">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm">
                <i data-lucide="sparkles" class="text-blueAccent w-6 h-6"></i>
              </div>
              <div>
                <h3 class="text-navy font-semibold text-lg">AI Career Discovery Ready</h3>
                <p class="text-gray-500 text-sm">
                  Start the guided survey and get career suggestions based on your profile.
                </p>
              </div>
            </div>

            <span class="text-sm text-blueAccent font-semibold bg-white px-4 py-2 rounded-full border border-blue-100 w-fit">
              Smart Survey Experience
            </span>
          </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
          <div class="xl:col-span-2 animate__animated animate__fadeInUp animate__delay-1s">
            <div id="heroCard" class="bg-[#dfe8f3] border border-blue-200 rounded-2xl p-8 shadow-sm h-full">
              <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 h-full">
                <div class="max-w-2xl">
                  <h2 class="text-3xl font-bold text-navy mb-3">
                    Start Your Career Discovery Survey
                  </h2>
                  <p class="text-gray-600 text-lg leading-relaxed mb-5">
                    This survey will show one question at a time to keep the interface clean,
                    focused, and easy to use without changing your original dashboard style.
                  </p>

                  <div class="flex flex-wrap gap-3">
                    <span class="bg-white/80 text-navy text-sm px-4 py-2 rounded-full border border-blue-100">25 Guided Questions</span>
                    <span class="bg-white/80 text-navy text-sm px-4 py-2 rounded-full border border-blue-100">Personalized Insights</span>
                    <span class="bg-white/80 text-navy text-sm px-4 py-2 rounded-full border border-blue-100">Career Matching</span>
                  </div>
                </div>

                <div class="flex flex-col items-start lg:items-end gap-4">
                  <button
                    id="startBtn"
                    class="btn-glow px-9 py-4 rounded-xl text-white font-semibold bg-gradient-to-r from-navySoft to-blueAccent flex items-center gap-3 text-lg shadow-md"
                  >
                    <i data-lucide="play-circle"></i>
                    Get Started
                  </button>

                  <p class="text-sm text-gray-500">
                    Estimated time: 5–7 minutes
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="animate__animated animate__fadeInUp animate__delay-1s">
            <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-sm h-full">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blueBg flex items-center justify-center">
                  <i data-lucide="clipboard-list" class="text-blueAccent w-5 h-5"></i>
                </div>
                <h3 class="text-xl font-semibold text-navy">Survey Preview</h3>
              </div>

              <div class="space-y-3 text-sm text-gray-600">
                <div class="p-3 rounded-xl bg-blueBg border border-blue-100">
                  Which subjects do you enjoy the most in school?
                </div>
                <div class="p-3 rounded-xl bg-blueBg border border-blue-100">
                  Which area are you strongest in?
                </div>
                <div class="p-3 rounded-xl bg-blueBg border border-blue-100">
                  What matters most to you in a future career?
                </div>
              </div>

              <div class="mt-5 pt-4 border-t border-blue-100">
                <p class="text-sm text-gray-500">
                  Questions appear one by one for a focused experience.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 animate__animated animate__fadeInUp animate__delay-2s">
          <div class="card-hover bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-blueBg flex items-center justify-center mb-4">
              <i data-lucide="brain" class="text-blueAccent"></i>
            </div>
            <h3 class="text-lg font-semibold text-navy mb-2">Know Your Strengths</h3>
            <p class="text-sm text-gray-500 leading-relaxed">
              Identify your skills, interests, and natural abilities through a guided survey.
            </p>
          </div>

          <div class="card-hover bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-blueBg flex items-center justify-center mb-4">
              <i data-lucide="target" class="text-blueAccent"></i>
            </div>
            <h3 class="text-lg font-semibold text-navy mb-2">Match Career Paths</h3>
            <p class="text-sm text-gray-500 leading-relaxed">
              Receive career suggestions that better align with your personality and goals.
            </p>
          </div>

          <div class="card-hover bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-blueBg flex items-center justify-center mb-4">
              <i data-lucide="trending-up" class="text-blueAccent"></i>
            </div>
            <h3 class="text-lg font-semibold text-navy mb-2">Track Your Progress</h3>
            <p class="text-sm text-gray-500 leading-relaxed">
              Save your results and come back later to review your development journey.
            </p>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate__animated animate__fadeInUp animate__delay-2s">
          <div class="bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-xl font-semibold text-navy">Why Kairos?</h3>
              <i data-lucide="shield-check" class="text-blueAccent"></i>
            </div>
            <p class="text-gray-500 leading-relaxed mb-4">
              Kairos helps students discover meaningful career options by combining passion,
              skills, hobbies, and future ambitions into one intelligent experience.
            </p>
            <div class="space-y-3 text-sm text-gray-600">
              <div class="flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4 text-blueAccent"></i>
                Clean one-question-at-a-time survey
              </div>
              <div class="flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4 text-blueAccent"></i>
                Student-friendly dashboard experience
              </div>
              <div class="flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4 text-blueAccent"></i>
                Focused on future career discovery
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-xl font-semibold text-navy">Your Activity</h3>
              <i data-lucide="activity" class="text-blueAccent"></i>
            </div>

            <div class="space-y-4">
              <div class="p-4 bg-blueBg rounded-xl border border-blue-100">
                <p class="text-sm text-gray-500">Survey Status</p>
                <p class="text-lg font-semibold text-navy" id="surveyStatus">Not Started Yet</p>
              </div>

              <div class="p-4 bg-blueBg rounded-xl border border-blue-100">
                <p class="text-sm text-gray-500">Saved Careers</p>
                <p class="text-lg font-semibold text-navy">0 Careers Saved</p>
              </div>

              <div class="p-4 bg-blueBg rounded-xl border border-blue-100">
                <p class="text-sm text-gray-500">Last Activity</p>
                <p class="text-lg font-semibold text-navy">Today</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- SURVEY SECTION -->
      <div id="surveySection" class="hidden-section animate__animated animate__fadeInUp">
        <div class="max-w-5xl">
          <div class="mb-8">
            <h1 class="text-4xl font-bold text-navy mb-3">Career Discovery Survey</h1>
            <p class="text-gray-500 text-lg">
              Answer each question carefully to help Kairos understand your profile better.
            </p>
          </div>

          <div class="bg-white border border-blue-100 rounded-2xl shadow-sm p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div>
                <h2 class="text-2xl font-semibold text-navy">Question Flow</h2>
                <p class="text-sm text-gray-500">One question at a time for a clean experience</p>
              </div>
              <div class="text-sm font-medium text-blueAccent" id="progressText">Question 1 of 25</div>
            </div>

            <div class="w-full bg-gray-100 rounded-full h-3 mb-8 overflow-hidden">
              <div id="progressBar" class="h-3 rounded-full bg-gradient-to-r from-navySoft to-blueAccent transition-all duration-300" style="width: 4%;"></div>
            </div>

            <div class="mb-6">
              <p class="text-2xl font-semibold text-navy leading-relaxed" id="questionText"></p>
            </div>

            <div id="answerContainer" class="space-y-3 mb-8"></div>

            <div class="flex items-center justify-between pt-2">
              <button
                id="prevBtn"
                class="px-6 py-3 rounded-xl border border-blue-200 text-navy font-medium hover:bg-blue-50 transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Previous
              </button>

              <button
                id="nextBtn"
                class="btn-glow px-8 py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-navySoft to-blueAccent flex items-center gap-2 shadow-md"
              >
                Next
                <i data-lucide="arrow-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- COMPLETION SECTION -->
      <div id="completionSection" class="hidden-section animate__animated animate__fadeInUp">
        <div class="max-w-4xl bg-white border border-blue-100 rounded-2xl shadow-sm p-10">
          <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-blueBg flex items-center justify-center">
              <i data-lucide="badge-check" class="text-blueAccent w-8 h-8"></i>
            </div>
            <div>
              <h2 class="text-3xl font-bold text-navy">Survey Completed</h2>
              <p class="text-gray-500">Your responses have been captured successfully.</p>
            </div>
          </div>

          <p class="text-gray-600 leading-relaxed mb-6">
            Great job. Kairos now has a stronger understanding of your passions, strengths,
            hobbies, and future goals. The next step is to connect these answers to career recommendations.
          </p>

          <div id="resultBox" class="mt-6 hidden">
            <div class="bg-blueBg border border-blue-100 rounded-2xl p-6">
              <h3 class="text-2xl font-semibold text-navy mb-4">Your Career Analysis</h3>

              <div class="mb-5">
                <h4 class="text-lg font-semibold text-navy mb-2">Category Scores</h4>
                <div id="categoryScores" class="grid grid-cols-1 md:grid-cols-2 gap-3"></div>
              </div>

              <div>
                <h4 class="text-lg font-semibold text-navy mb-2">Top Career Recommendations</h4>
                <div id="careerRecommendations" class="space-y-3"></div>
              </div>
            </div>
          </div>

          <div class="flex flex-wrap gap-4 mt-6">
            <button id="restartBtn" class="px-6 py-3 rounded-xl border border-blue-200 text-navy font-medium hover:bg-blue-50 transition">
              Restart Survey
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
    lucide.createIcons();

    const studentId = 1; // change later to logged-in student id

    const surveyQuestions = [
      { question: "Which subjects do you enjoy the most in school?", type: "text" },
      { question: "Which activity makes you lose track of time (you enjoy it that much)?", type: "text" },
      { question: "Do you prefer:", type: "radio", options: ["Solving problems", "Creating things", "Helping people", "Leading others"] },
      { question: "If you had no restrictions, what career would you choose?", type: "text" },
      { question: "Which of these excites you the most?", type: "radio", options: ["Technology & innovation", "Business & money", "Arts & creativity", "Science & research", "Social impact"] },
      { question: "Which area are you strongest in?", type: "radio", options: ["Math / Logic", "Communication", "Creativity", "Leadership", "Practical skills"] },
      { question: "How confident are you in solving difficult problems? (1–5 scale)", type: "scale" },
      { question: "Do people usually come to you for help in studies or advice?", type: "radio", options: ["Yes", "No", "Sometimes"] },
      { question: "How good are you at working with technology (computers, apps, etc.)? (1–5 scale)", type: "scale" },
      { question: "Which describes you best?", type: "radio", options: ["Analytical thinker", "Creative thinker", "Practical doer", "People person"] },
      { question: "How well do you handle new challenges? (1–5 scale)", type: "scale" },
      { question: "Which hobbies do you enjoy the most?", type: "radio", options: ["Gaming", "Sports", "Reading", "Designing / Drawing", "Coding / Tech", "Social activities"] },
      { question: "Have you ever built, created, or achieved something you are proud of? (Explain briefly)", type: "textarea" },
      { question: "Do you prefer:", type: "radio", options: ["Indoor activities", "Outdoor activities", "Both"] },
      { question: "How often do you participate in extracurricular activities?", type: "radio", options: ["Never", "Sometimes", "Often"] },
      { question: "What are you doing in an extracurricular activity?", type: "text" },
      { question: "Do you prefer working?", type: "radio", options: ["Alone", "In a team"] },
      { question: "Are you more:", type: "radio", options: ["Introverted", "Extroverted", "Balanced"] },
      { question: "How do you make decisions?", type: "radio", options: ["Logical thinking", "Emotions / feelings", "Advice from others"] },
      { question: "Do you like taking leadership roles?", type: "radio", options: ["Yes", "No", "Sometimes"] },
      { question: "What matters most to you in a future career?", type: "radio", options: ["High salary", "Job stability", "Passion / enjoyment", "Helping others", "Fame / recognition"] },
      { question: "How important is work-life balance to you? (1–5 scale)", type: "scale" },
      { question: "Are you willing to study/work hard for long-term success?", type: "radio", options: ["Yes", "No", "Maybe"] },
      { question: "What kind of impact do you want to make in the future?", type: "radio", options: ["Help society", "Innovate new things", "Build a business", "Support family", "Not sure yet"] },
      { question: "Any additional passion, skill, or goal you want Kairos to know about?", type: "textarea" }
    ];

    let currentQuestion = 0;
    const answers = {};

    const dashboardContent = document.getElementById("dashboardContent");
    const surveySection = document.getElementById("surveySection");
    const completionSection = document.getElementById("completionSection");
    const startBtn = document.getElementById("startBtn");
    const restartBtn = document.getElementById("restartBtn");
    const questionText = document.getElementById("questionText");
    const answerContainer = document.getElementById("answerContainer");
    const progressText = document.getElementById("progressText");
    const progressBar = document.getElementById("progressBar");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const surveyStatus = document.getElementById("surveyStatus");

    startBtn.addEventListener("click", () => {
      dashboardContent.classList.add("hidden-section");
      surveySection.classList.remove("hidden-section");
      surveyStatus.textContent = "In Progress";
      renderQuestion();
    });

    restartBtn.addEventListener("click", () => {
      currentQuestion = 0;
      Object.keys(answers).forEach(key => delete answers[key]);

      completionSection.classList.add("hidden-section");
      dashboardContent.classList.remove("hidden-section");
      surveyStatus.textContent = "Not Started Yet";

      const resultBox = document.getElementById("resultBox");
      const categoryScores = document.getElementById("categoryScores");
      const careerRecommendations = document.getElementById("careerRecommendations");

      resultBox.classList.add("hidden");
      categoryScores.innerHTML = "";
      careerRecommendations.innerHTML = "";
    });

    prevBtn.addEventListener("click", () => {
      saveAnswer();
      if (currentQuestion > 0) {
        currentQuestion--;
        renderQuestion();
      }
    });

    nextBtn.addEventListener("click", async () => {
      saveAnswer();

      if (currentQuestion < surveyQuestions.length - 1) {
        currentQuestion++;
        renderQuestion();
      } else {
        try {
          nextBtn.disabled = true;
          nextBtn.innerHTML = `Submitting...`;

          const response = await fetch("submit_survey.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              student_id: studentId,
              answers: answers
            })
          });

          const result = await response.json();

          if (!result.success) {
            alert(result.message || "Failed to submit survey.");
            nextBtn.disabled = false;
            nextBtn.innerHTML = `Submit <i data-lucide="check-circle"></i>`;
            lucide.createIcons();
            return;
          }

          surveySection.classList.add("hidden-section");
          completionSection.classList.remove("hidden-section");
          surveyStatus.textContent = "Completed";
          showResults(result);

        } catch (error) {
          console.error(error);
          alert("An error occurred while submitting the survey.");
          nextBtn.disabled = false;
          nextBtn.innerHTML = `Submit <i data-lucide="check-circle"></i>`;
          lucide.createIcons();
        }
      }
    });

    function renderQuestion() {
      const q = surveyQuestions[currentQuestion];
      const questionId = currentQuestion + 1;

      questionText.textContent = q.question;
      progressText.textContent = `Question ${currentQuestion + 1} of ${surveyQuestions.length}`;
      progressBar.style.width = `${((currentQuestion + 1) / surveyQuestions.length) * 100}%`;

      answerContainer.innerHTML = "";

      if (q.type === "text") {
        answerContainer.innerHTML = `
          <input
            type="text"
            id="answerInput"
            class="w-full p-4 rounded-xl border border-blue-200 bg-white focus:outline-none focus:ring-2 focus:ring-blueAccent"
            placeholder="Type your answer here"
            value="${answers[questionId] || ""}"
          />
        `;
      }

      if (q.type === "textarea") {
        answerContainer.innerHTML = `
          <textarea
            id="answerInput"
            rows="5"
            class="w-full p-4 rounded-xl border border-blue-200 bg-white focus:outline-none focus:ring-2 focus:ring-blueAccent"
            placeholder="Write your answer here"
          >${answers[questionId] || ""}</textarea>
        `;
      }

      if (q.type === "radio") {
        answerContainer.innerHTML = q.options.map(option => `
          <label class="survey-option flex items-center gap-3 p-4 border border-blue-100 rounded-xl cursor-pointer transition">
            <input
              type="radio"
              name="answer"
              value="${option}"
              class="accent-blue-600"
              ${answers[questionId] === option ? "checked" : ""}
            />
            <span class="text-gray-700 font-medium">${option}</span>
          </label>
        `).join("");
      }

      if (q.type === "scale") {
        answerContainer.innerHTML = `
          <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
            ${[1,2,3,4,5].map(num => `
              <label class="survey-option flex flex-col items-center justify-center p-5 border border-blue-100 rounded-xl cursor-pointer transition">
                <input
                  type="radio"
                  name="answer"
                  value="${num}"
                  class="mb-3 accent-blue-600"
                  ${String(answers[questionId]) === String(num) ? "checked" : ""}
                />
                <span class="font-semibold text-navy text-lg">${num}</span>
              </label>
            `).join("")}
          </div>
        `;
      }

      prevBtn.disabled = currentQuestion === 0;

      if (currentQuestion === surveyQuestions.length - 1) {
        nextBtn.innerHTML = `Submit <i data-lucide="check-circle"></i>`;
      } else {
        nextBtn.innerHTML = `Next <i data-lucide="arrow-right"></i>`;
      }

      nextBtn.disabled = false;
      lucide.createIcons();
    }

    function saveAnswer() {
      const q = surveyQuestions[currentQuestion];
      const questionId = currentQuestion + 1;

      if (q.type === "text" || q.type === "textarea") {
        const input = document.getElementById("answerInput");
        if (input) {
          answers[questionId] = input.value.trim();
        }
      }

      if (q.type === "radio" || q.type === "scale") {
        const selected = document.querySelector('input[name="answer"]:checked');
        if (selected) {
          answers[questionId] = selected.value;
        }
      }
    }

    function showResults(result) {
      const resultBox = document.getElementById("resultBox");
      const categoryScores = document.getElementById("categoryScores");
      const careerRecommendations = document.getElementById("careerRecommendations");

      categoryScores.innerHTML = "";
      careerRecommendations.innerHTML = "";

      if (result.category_scores) {
        Object.entries(result.category_scores).forEach(([category, score]) => {
          categoryScores.innerHTML += `
            <div class="bg-white rounded-xl border border-blue-100 p-4">
              <p class="text-sm text-gray-500 capitalize">${category.replace("_", " ")}</p>
              <p class="text-xl font-bold text-navy">${score}</p>
            </div>
          `;
        });
      }

      if (result.recommendations && result.recommendations.length > 0) {
        result.recommendations.forEach((career, index) => {
          careerRecommendations.innerHTML += `
            <div class="bg-white rounded-xl border border-blue-100 p-4">
              <p class="text-sm text-gray-500">Recommendation ${index + 1}</p>
              <p class="text-lg font-bold text-navy">${career.career_name}</p>
              <p class="text-sm text-blueAccent font-semibold">${career.match_percent}% match</p>
              <p class="text-sm text-gray-600 mt-1">${career.description || ""}</p>
            </div>
          `;
        });
      }

      resultBox.classList.remove("hidden");
    }
  </script>
</body>
</html>