/** Modulo que contiene varias funciones utiles para usar en la aplicacion
 * @author
 * @since
 */
var Util = {};

/**
 * Funcion que define variables y funciones
 */
(function () {
    /**
     * Carga datepicker de jQueryUI
     * @param {String} id, id del campo
     */
    Util.applyDatepicker = function (id) {
        $("#" + id).datepicker($.datepicker.regional[ "es" ]);
        $("#" + id).datepicker({changeMonth: true, changeYear: true});
        $("#" + id).datepicker("option", "dateFormat", "yy-mm-dd");
    };

    /**
     * Hace request por AJAX
     * @param {JSON} ladata, paramétros del request
     * @param {function} successCallBackFn, función que captura la respuesta onSuccess
     */
    Util.callAjax = function (data, url, method, successCallBackFn, errorCallBackFn) {
        Util.cursorBusy();
        successCallBackFn = (successCallBackFn) ? successCallBackFn : Util.successDefaultAjaxRequest;
        errorCallBackFn = (errorCallBackFn) ? errorCallBackFn : Util.errorDefaultAjaxRequest;
        $.ajax({
            data: data,
            type: method,
            dataType: "json",
            url: url,
            headers: {'X-CSRF-TOKEN': data.token},
            success: function (data, textStatus, jqXHR) {
                Util.cursorNormal();
                successCallBackFn(data, textStatus, jqXHR);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Util.cursorNormal();
                errorCallBackFn(jqXHR, textStatus, errorThrown);
            }
        });
    };

    /*
     * Metodo por defecto para capturar peticiones ajax exitosas
     */
    Util.successDefaultAjaxRequest = function (data, textStatus, jqXHR) {
        console.log(data);
        console.log(textStatus);
        console.log(jqXHR);
    };

    /*
     * Metodo por defecto para capturar peticiones ajax con errores
     */
    Util.errorDefaultAjaxRequest = function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        alert('ocurrio un error: ' + textStatus + '. \n\n' + errorThrown);
    };

    /**
     * Limppia un formulario
     * @param {String} id, id del formulario
     */
    Util.clearForm = function (id) {
        $("#" + id + " :input").each(function () {
            if ('button' != $(this).attr('type')) {
                $(this).val('');
            }
        });
        $('select').val('seleccione');
    };

    Util.clearForm2 = function (id) {
        $("#" + id + " :input").each(function () {
            if ('button' != $(this).attr('type')) {
                $(this).val('');
            }
        });
    };

    /**
     * Pone el cursor ocupado
     */
    Util.cursorBusy = function () {
        $('body').css('cursor', 'wait');
    };

    /**
     * Pone el cursor normal
     */
    Util.cursorNormal = function () {
        $('body').css('cursor', '');
    };

    /**
     * Verifica que un correo esta bien escrito
     * @param {String} email
     * @returns {bool},
     */
    Util.isEmail = function (email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    };

    Util.parcejson = function () {
        var str = '{\"registro_fecha\":\"2013-02-10\",\"registro_sistema\":\"nombre sistema\",\"registro_actividad\":\"4\",\"undefined\":\"CARGAR\",\"registro_campo01\":\"2 horas\",\"registro_campo02\":\"0\",\"registro_campo03\":\"2013-02-12\",\"registro_campo04\":\"1\",\"registro_campo05\":\"0\",\"registro_campo06\":\"cerrado autom","nota":"las notas van aqu","fecha":"2013-02-10","tsfecha":"2013-02-10 08:23:13"}';
        var obj = JSON.parse(str);
        alert('registro_fecha1 = ' + obj.registro_fecha);
        alert('registro_fecha2 = ' + obj["registro_fecha"]);
        $("#registro :input").each(function () {
            var idprop = $(this).attr('id');
            if (obj.hasOwnProperty(idprop)) {
                $(this).val(obj[idprop]);
            }
        });
    };

    /**
     * Llena un formulario con un objeto JSON
     * @param {String} id
     * @param {JSON} jo
     */
    Util.populateForm = function (id, jo) {
        $("#" + id + " :input").each(function () {
            var p = $(this).attr('id');
            if (jo.hasOwnProperty(p)) {
                $(this).val(jo[p]);
            }
        });
    };

    /**
     * Carga un estilo a un campo
     * @param {type} id
     */
    Util.setrequirefield = function (id) {
        $("#" + id).addClass("requirefield");
    };

    /**
     * convierte los campos de un formulario en StringJSON
     * @param {type} id, id del formulario
     * @returns {String}, JSON en forma de String
     */
    Util.stringifyFormJson = function (id) {
        var jo = {};
        $("#" + id + " :input").each(function () {
            jo[$(this).attr('id')] = $(this).val();
        });
        return JSON.stringify(jo);
    };

    /**
     * Oculta o muestra un elemento
     * @param String id
     * @param Bool show
     */
    Util.byIdShowHide = function (id, show) {
        if (show) {
            $('#' + id).show();
        } else {
            $('#' + id).hide();
        }
    };

    Util.confirmDelete = function (e) {
        return window.confirm('\n\nVa a eliminar información de forma permanente. \n\n\n\n¿Desea continuar?\n\n');
    };

    Util.confirmProceso = function (e) {
        return window.confirm('\n\n Desea terminar el proceso actual. \n\n\n\n¿Desea continuar?\n\n');
    };

    Util.errorMessageShowHide = function (id, show, message) {
        if (show) {
            $('#' + id).next().addClass('alert').addClass('alert-danger');
            $('#' + id).next().html(message);
        } else {
            $('#' + id).next().removeClass();
            $('#' + id).next().html('');
        }
    };

    /**
     * Metodo para capturar el atributo value de un elemento
     * @param {String} id
     * @returns {document.getElementById.value}
     */
    Util.getValue = function (id) {
        var e = document.getElementById(id);
        if (e != null && e != undefined) {
            return e.value;
        }
        return null;
    };


    /**La función softArrOfObjectsByParam(); ordena una tabla que contiene objetos (estructuras), basándose en un parámetro como criterio de ordenación.
     * Sorts an array of objects (note: sorts the original array and returns nothing)
     *  @arrToSort             array           javascript array of objects
     * @strObjParamToSortBy   string          name of obj param to sort by, and an
     * @sortAsc               bool (optional) sort ascending or decending (defaults to true and sorts in ascending order)
     *  returns                void            because the original array that gets passed in is sorted
     * [sortArrOfObjectsByParam description]
     * @param  {[type]} arrToSort [description]
     * @return {[type]}           [description]
     * http://www.yoelweblog.com/2015/03/js-ordenar-array-de-objetos-por-parametro/
     */
    Util.sortArrOfObjectsByParam = function (arrToSort /* array */, strObjParamToSortBy /* string */, sortAscending /* bool(optional, defaults to true) */) {
        if (sortAscending == undefined)
            sortAscending = true;  // default to true
        if (sortAscending) {
            arrToSort.sort(function (a, b) {
                return a[strObjParamToSortBy] > b[strObjParamToSortBy];
            });
        }
        else {
            arrToSort.sort(function (a, b) {
                return a[strObjParamToSortBy] < b[strObjParamToSortBy];
            });
        }
    }

    /**
     * Metodo para ordenar un array Numerico ascedentemente
     * [OrdenarNumerosAscendentemente description]
     * @param {[type]} a [description]
     * @param {[type]} b [description]
     */
    Util.OrdenarNumerosAscendentemente = function (a , b) {
        return (a-b);
    }

    /**
     * Metodo que inicializa el modulo
     */
    Util.initialize = function () {
    };

})();

/**
 * Funcion de inicializacion en el momento en que se completa el DOM llamada
 * desde jquery Esta funcion realiza los procesos de inicializacion de la
 * aplicacion
 */
$(function () {
    Util.initialize();
});
