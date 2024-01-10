/**
 * Returns a new string that comes between prev and next in lexicographic order.
 * https://stackoverflow.com/questions/38923376/return-a-new-string-that-sorts-between-two-given-strings/38927158#38927158
 *
 * @param {string} prev the lower-bound string.
 * @param {string} next the upper-bound string.
 */
export function midString(prev: string, next: string) {
    let p = 0;
    let n = 0;
    let pos = 0;
    let str = "";

    // find leftmost non-matching character
    for (pos = 0; p == n; pos++) {
        p = pos < prev.length ? prev.charCodeAt(pos) : 96;
        n = pos < next.length ? next.charCodeAt(pos) : 123;
    }

    str = prev.slice(0, pos - 1); // copy identical part of string

    if (p == 96) {
        // prev string equals beginning of next
        while (n == 97) {
            // next character is 'a'
            n = pos < next.length ? next.charCodeAt(pos++) : 123; // get char from next
            str += "a"; // insert an 'a' to match the 'a'
        }
        if (n == 98) {
            // next character is 'b'
            str += "a"; // insert an 'a' to match the 'b'
            n = 123; // set to end of alphabet
        }
    } else if (p + 1 == n) {
        // found consecutive characters
        str += String.fromCharCode(p); // insert character from prev
        n = 123; // set to end of alphabet
        while ((p = pos < prev.length ? prev.charCodeAt(pos++) : 96) == 122) {
            // p='z'
            str += "z"; // insert 'z' to match 'z'
        }
    }
    return str + String.fromCharCode(Math.ceil((p + n) / 2)); // append middle character
}

/**
 * Given a number of iterations, it will generate that many lexicographically
 * equally-spaced keys.
 * https://stackoverflow.com/questions/38923376/return-a-new-string-that-sorts-between-two-given-strings/38927158#38927158
 *
 * @param {number} num number of keys to generate.
 */
export function seqString(num: number) {
    var chars = Math.floor(Math.log(num) / Math.log(26)) + 1;
    var prev = Math.pow(26, chars - 1);
    var ratio = chars > 1 ? (num + 1 - prev) / prev : num;
    var part = Math.floor(ratio);
    var alpha = [partialAlphabet(part), partialAlphabet(part + 1)];
    var leap_step = ratio % 1,
        leap_total = 0.5;
    var first = true;
    var strings: string[] = [];
    generateStrings(chars - 1, "");
    return strings;

    function generateStrings(full: number, str: string) {
        if (full) {
            for (var i = 0; i < 26; i++) {
                generateStrings(full - 1, str + String.fromCharCode(97 + i));
            }
        } else {
            if (!first) strings.push(stripTrailingAs(str));
            else first = false;
            var leap = Math.floor((leap_total += leap_step));
            leap_total %= 1;
            for (var i = 0; i < part + leap; i++) {
                strings.push(str + alpha[leap][i]);
            }
        }
    }
    function stripTrailingAs(str: string) {
        var last = str.length - 1;
        while (str.charAt(last) == "a") --last;
        return str.slice(0, last + 1);
    }
    function partialAlphabet(num: number) {
        var magic = [
            0, 4096, 65792, 528416, 1081872, 2167048, 2376776, 4756004, 4794660,
            5411476, 9775442, 11097386, 11184810, 22369621,
        ];
        var bits = num < 13 ? magic[num] : 33554431 - magic[25 - num];
        var chars = [];
        for (var i = 1; i < 26; i++, bits >>= 1) {
            if (bits & 1) chars.push(String.fromCharCode(97 + i));
        }
        return chars;
    }
}
