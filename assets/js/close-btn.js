const closeBtn = document.querySelector("#close-btn");
const closeDisplay = document.querySelector("#close-display");

closeBtn.addEventListener("click", () => {
  setTimeout(() => {
    loginForm.style.display = "block";
    closeDisplay.style.display = "none";
  }, 5000);
  loginForm.style.display = "none";
  closeDisplay.style.display = "block";
});
