function myFunction() {
    // Mostrar el diálogo de confirmación
    let text = "Do you want to delete this.";
    let result = confirm(text);
    
    // Establecer el valor del campo oculto result
    $('#result').val(result ? 'true' : 'false');
    
    // Permitir o cancelar el envío del formulario según el resultado del diálogo de confirmación
    return result;
}