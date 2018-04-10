*Usage*
```
$ ./anagram app:anagram abc itookablackcab
```
If any arguments is not passed then application will ask to provide it

================================

Obiettivo:
Verificare che un anagramma di una stringa sia contenuto in un’altra stringa.

Task:
Preparare uno script a command-line che accetti in input 2 stringhe, che
controlli se una stringa A sia un qualsiasi anagramma contenuto in una stringa B
e che stampi a video “vero” o “falso” in base al risultato del confronto.

Esempio:
Date due stringhe A = "abc" e B = "itookablackcab" lo script stamperà a video
"vero", poiché anagrammando A si può trovare una occorrenza di "cab" nella
stringa B.

Assumi che:
 - Il codice sia sviluppato preferibilmente in PHP.
 - A sia una stringa di lunghezza massima di 1024 caratteri.
 - B sia una stringa di lunghezza massima di 1024 caratteri.
 - Non ci siano funzioni native che effettuino l’anagramma di una stringa.
 - Il controllo sia case-insensitive.