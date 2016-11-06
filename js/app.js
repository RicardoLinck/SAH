;(function (document, window, $, undefined){
    $(document).ready(function(){
        $('form').validate({
            errorPlacement(error, element){
                var container = $('<div class="alert alert-danger error-container"></div>');
                container.html(error);
                element.parent().append(container);
            },
            success: function(label) {
                label.parent().remove();
            },
            messages:{
                'email':{
                    required:"O campo “E-mail” é de preenchimento obrigatório.",
                    email: "O e-mail informado para autenticação, não é um e-mail válido."
                },
                'password':{
                    required:"O campo “Senha” é de preenchimento obrigatório."
                },
                'data':{
                    required:"O campo “Data” é de preenchimento obrigatório."
                },
                'hora-entrada':{
                    required:"O campo “Hora Entrada” é de preenchimento obrigatório."
                },
                'hora-saida':{
                    required:"O campo “Hora Saída” é de preenchimento obrigatório."
                }
            }
        });
    });
}(document,window,jQuery));