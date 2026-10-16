const idMessage = document.querySelector("#message-cu");
const loginForm = document.querySelector("#login-form-cu");

loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const email = document.querySelector("#email");
  const password = document.querySelector("password");

  try {
    const response = await fetch("../api/create-user.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email, password }),
    });
    const result = await response.json();

    idMessage.textContent = result.message;

    if (result.success) {
      FormData.reset();
      window.location.href("../../index.html");
    }
  } catch (error) {
    idMessage.textContent = "Unable to connect to the server.";
    console.error("Create user request failed");
  }
});
