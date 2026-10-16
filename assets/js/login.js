const loginForm = document.querySelector("#login-form");
const idMessage = document.querySelector("#message");

let numOfTries = 1;

loginForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  const formData = new FormData(loginForm);
  try {
    const response = await fetch("/api/login.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();
    if (result.success) {
      numOfTries = 0;
      window.location.href = "../../pages/main.html";
    } else {
      ++numOfTries;
      idMessage.innerHTML = result.message;
    }
  } catch (error) {
    console.error("Login failed:", error);
    t;
  }
});
