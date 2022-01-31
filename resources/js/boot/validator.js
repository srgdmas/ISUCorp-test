import * as methods from 'vuelidate/lib/validators'
import {regex} from 'vuelidate/lib/validators/common'

import Vue from 'vue'

Vue.prototype.$rules = {
    is(value, message) {
        message = message !== undefined ? message : false;
        return (val) => {
            let result;
            switch (typeof value) {
                case 'string':
                    result = String(val) === value;
                    break;
                case 'number':
                    result = Number(val) === value;
                    break;
                default:
                    result = val === value
            }
            return result || message
        }
    },
    required(message = false) {
        return (val) => methods.required(val) || message
    },
    minLength(length, message) {
        message = message !== undefined ? message : false;
        return (val) => methods.minLength(length)(val) || message
    },
    maxLength(length, message) {
        message = message !== undefined ? message : false;
        return (val) => methods.maxLength(length)(val) || message
    },
    minValue(value, message) {
        message = message !== undefined ? message : false;
        return (val) => methods.minValue(value)(val) || message
    },
    maxValue(value, message) {
        message = message !== undefined ? message : false;
        return (val) => methods.maxValue(value)(val) || message
    },
    between(min, max, message) {
        message = message !== undefined ? message : false;
        return (val) => methods.between(min, max)(val) || message
    },
    betweenLength(min, max, message) {
        message = message !== undefined ? message : false;

        return (val) => methods.minLength(min)(val) && methods.maxLength(max)(val) || message
    },
    alpha(message = false) {
        return (val) => methods.alpha(val) || message
    },
    alphaNum(message = false) {
        return (val) => methods.alphaNum(val) || message
    },
    numeric(message = false) {
        return (val) => methods.numeric(val) || message
    },
    integer(message = false) {
        return (val) => methods.integer(val) || message
    },
    decimal(message = false) {
        return (val) => methods.decimal(val) || message
    },
    email(message = false) {
        return (val) => methods.email(val) || message
    },
    ipAddress(message = false) {
        return (val) => methods.ipAddress(val) || message
    },
    macAddress(separator = ':', message = false) {
        return (val) => methods.macAddress(separator)(val) || message
    },
    url(message = false) {
        return (val) => methods.url(val) || message
    },
    or(...args) {
        let message = false;
        if (typeof args[args.length - 1] === 'string') {
            message = args.pop()
        }
        return (val) => methods.or(...args)(val) || message
    },
    and(...args) {
        let message = false;
        if (typeof args[args.length - 1] === 'string') {
            message = args.pop()
        }
        return (val) => methods.and(...args)(val) || message
    },
    not(rule, message = false) {
        return (val) => methods.not(rule)(val) || message
    },
    version(message = false) {
        return (val) => regex('version', /^([1-9]\d*).([1-9]\d*).([1-9]\d*).([1-9]\d*)$/)(val) || message
    },
    dni() {
        return (val) => {
            var numero, letr, letra;
            var expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;
            let dni = val.toUpperCase();
            if (expresion_regular_dni.test(dni) === true) {
                numero = dni.substr(0, dni.length - 1);
                numero = numero.replace('X', 0);
                numero = numero.replace('Y', 1);
                numero = numero.replace('Z', 2);
                letr = dni.substr(dni.length - 1, 1);
                numero = numero % 23;
                letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
                letra = letra.substring(numero, numero + 1);
                if (letra == letr) {
                    return true;
                }
            }
            return false;
        }
    },
    alphaspace(message = false) {
        return (val) => {
            val = val.split(' ').join('');
            return methods.alpha(val) || message}
    },
    password(message = false) {
        return (val) => {
            let rule1 = /[a-zA-Z]/.test(val)
            let rule2 = /[0-9]/.test(val)
            return (rule1 && rule2) || message}
    },
};
