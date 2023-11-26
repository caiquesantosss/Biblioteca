function CountLetters() {
    var inputTexto = document.getElementById('senha')
    var quantidadeLetras = inputTexto.value.length
    var visibleIcon = document.getElementById("eyeicon")
        if(quantidadeLetras > 0) {
            visibleIcon.style.display = "block"
        } else if (quantidadeLetras == 0) {
            visibleIcon.style.display = "none"         
        }
}


function VisiblePassword() {
    var senhaInput = document.getElementById('senha');
    senhaInput.type = senhaInput.type === 'password' ? 'text' : 'password';
}

