const loginForm = document.querySelector("#login-form");
const idMessage = document.querySelector("#message");
const forgotMessage = document.querySelector("#forgot");
const closeBtn = document.querySelector("#close-btn");
const closeDisplay = document.querySelector("#close-display");

let numOfTries = 1;

loginForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  console.log(numOfTries);
  const formData = new FormData(loginForm);
  const response = await fetch("/api/login.php", {
    method: "POST",
    body: formData,
  });
  if (numOfTries >= 2) {
    forgotMessage.outerHTML = `<a href='#'>forgot password or email?</a>`;
  }
  const result = await response.json();
  if (result.success) {
    numOfTries = 0;
    window.location.href = "/index.html";
  } else {
    ++numOfTries;
    idMessage.innerHTML = result.message;
  }
});

closeBtn.addEventListener("click", () => {
  setTimeout(() => {
    loginForm.style.display = "block";
    closeDisplay.style.display = "none";
  }, 5000);
  loginForm.style.display = "none";
  closeDisplay.style.display = "block";
});
