
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.querySelector("form");
        
        form.addEventListener("submit", (event) => {
            event.preventDefault(); // Evita o envio padrão do formulário
            
            // Exibe a notificação
            alert("Enviamos sua chave de mudança de senha no email informado.");
        });
    });

