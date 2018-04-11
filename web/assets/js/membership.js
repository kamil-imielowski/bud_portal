// $('.initPT').click(function () {
//     var plan = $(this).data("plan");
//     $.ajax({
//         url: "{{ path('initTransaction', {'slug': 'plan'})|escape('js') }}",
//         method: "POST",
//         data: {"plan": plan},
//         success: function(results){
//             alert(results);
//         }
//     })
// })