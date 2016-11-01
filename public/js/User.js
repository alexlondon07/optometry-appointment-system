/** Modulo que contiene llas funciones y variables necesarias para el modulo usuarios
 * @author Alexander Londoño
 * @since 2016-09-26
 */
var User = {};

/**
 * Funcion que define variables y funciones
 */
(function() {
    /**
     * Metodo que inicializa el modulo
     */
    User.initialize = function() {
          $('#users').DataTable();
    };

})();
/** funcion que se ejecuta al terminar el cargar el documento */
$(function() {
    User.initialize();
});
