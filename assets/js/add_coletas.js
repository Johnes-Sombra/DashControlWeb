const form = document.getElementById('form-coleta');
const mensagem = document.getElementById('mensagem-sucesso');

form.addEventListener('submit', function (e) {
    e.preventDefault();
    mensagem.textContent = "Coleta salva com sucesso!";
    setTimeout(() => mensagem.textContent = "", 3000);
    form.reset();
});
