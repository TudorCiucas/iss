var InsuranceValidateClient = {

    /**
     * 13 caractere numerice
     * @returns {boolean}
     */
    validateCnp: function (cnpNumber) {
        var i = 0,
            year = 0,
            hashResult = 0,
            cnp = [],
            hashTable = [2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9];
        if (cnpNumber.length !== 13) {
            return false;
        }
        for (i = 0; i < 13; i++) {
            cnp[i] = parseInt(cnpNumber.charAt(i), 10);
            if (isNaN(cnp[i])) {
                return false;
            }
            if (i < 12) {
                hashResult = hashResult + ( cnp[i] * hashTable[i] );
            }
        }
        hashResult = hashResult % 11;
        if (hashResult === 10) {
            hashResult = 1;
        }
        year = (cnp[1] * 10) + cnp[2];
        switch (cnp[0]) {
            case 1 :
            case 2 :
            {
                year += 1900;
            }
                break;
            case 3 :
            case 4 :
            {
                year += 1800;
            }
                break;
            case 5 :
            case 6 :
            {
                year += 2000;
            }
                break;
            case 7 :
            case 8 :
            case 9 :
            {
                year += 2000;
                if (year > ( parseInt(new Date().getYear(), 10) - 14 )) {
                    year -= 100;
                }
            }
                break;
            default :
            {
                return false;
            }
        }
        if (year < 1800 || year > 2099) {
            return false;
        }
        return ( cnp[12] === hashResult );
    },

    /**
     * RO urmat de caractere numerice
     * @returns {boolean}
     */
    validateCui: function (cui) {
        var regExp = /^(RO)?([0-9])+$/i;
        var match = regExp.exec(cui);
        if (match[1] !== undefined && match[2] !== undefined) {
            return true;
        } else {
            return false;
        }
    }
};
