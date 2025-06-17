function validarLogin() {
  const user = document.getElementById('username').value.trim();
  const passwd = document.getElementById('password').value.trim();
  const msg = document.getElementById('mensagem');

  if (user === "adamastor" && passwd === "123123") {
    msg.textContent = "Login bem-sucedido!";
    msg.className = "message success";

    // Redireciona após pequeno atraso
    setTimeout(() => {
        window.location.href = "../menu_principal/";
    }, 1000);

  } else {
    msg.textContent = "Usuário ou senha incorretos.";
    msg.className = "message error";
  }
}
