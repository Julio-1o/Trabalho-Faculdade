document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        // Se você quiser que o JS faça validações E o PHP abra em nova aba:
        // NÃO chame event.preventDefault() AQUI,
        // A MENOS QUE haja um ERRO de validação no JS.

        // 1. Validação do Telefone
        const telefoneInput = document.getElementById('telefone');
        const telefonePattern = /^[0-9]{2} [0-9]{5}-[0-9]{4}$/;

        if (!telefonePattern.test(telefoneInput.value)) {
            alert('Por favor, insira o telefone no formato correto: XX XXXXX-XXXX');
            telefoneInput.focus();
            event.preventDefault(); // IMPEDE o envio se houver erro
            return;
        }

        // 2. Validação da Data de Entrega
        const dataEntregaInput = document.getElementById('data-entrega');
        const dataEntrega = new Date(dataEntregaInput.value + 'T00:00:00');
        const hoje = new Date();
        hoje.setHours(0, 0, 0, 0);

        if (dataEntrega < hoje) {
            alert('A data de entrega deve ser no futuro.');
            dataEntregaInput.focus();
            event.preventDefault(); // IMPEDE o envio se houver erro
            return;
        }

        // Se o código chegar até aqui, significa que as validações JS passaram.
        // O formulário será enviado normalmente (para a nova aba devido ao target="_blank").
        // Você pode exibir um alerta simples na aba original, mas ela não será recarregada.
        // alert('Validação JS OK! Enviando para API.php em nova aba.');
        // form.reset(); // Pode resetar o formulário na aba original após o envio
    });
});