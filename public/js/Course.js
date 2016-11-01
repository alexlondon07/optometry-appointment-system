/** Modulo que contiene llas funciones y variables necesarias para el modulo usuarios
 * @author Alexander Londoño
 * @since 2016-11-01
 */
var Course = {};

/**
 * Funcion que define variables y funciones
 */
(function() {
    /**
     * Metodo que inicializa el modulo
     */
    Course.initialize = function() {
          $('#courses').DataTable();
    };

})();
/** funcion que se ejecuta al terminar el cargar el documento */
$(function() {
    Course.initialize();
});
