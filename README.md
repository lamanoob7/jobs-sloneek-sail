# Job Task

## Background

- Potrebujeme vytvoriť REST API systém ktorý by distribuoval články od bloggerov ku odberateľom.
- Odberateľov môže byť niekoľko desiatok tisíc, blogerov niekoľko desiatok.
- Aktívny prístup do systému majú len bloggeri skrz login, odberatelia ho nemajú..
- Každy článok ma kategóriu, taktiež blogger prispieva článkami minimálne do jednej alebo viac kategorií. Blogger NEMÔŽE
  vytvoriť článok v inej kategorií než ku ktorej je priradený.
- Články sa distribuujú odberateľom 2x denne, po uzávierke ktorá je ráno o 11:00 a poobede o 17:00. Distribujú sa len
  články ktoré ešte neboli distribuované.
- Distribúcia prebieha formou emailu, kde sa zhrnú všetky články odovzdané pred uzávierkou do jedného emailu - nechceme
  spamovať odberateľov novým emailom pre každý nový článok.

## Requirements

1. Pripraviť si Doctrine entities, Doctrine repositories, DB seeders pre Blogger, Subscriber, Article, ArticleCategory
2. Pripraviť si autentifikáciu pre bloggerov, najlepšie pomocou Bearer JWT tokenov
3. Pripraviť si autorizáciu pre bloggerov, pozor dávať na vlastníctvo článkov a prístup do kategorií
4. Pripraviť CRUD pre Articles (nedovoliť update/delete už distribuovaných článkov), GET pre ArticleCategory, GET
   pre subscribers - myslieť na potencionálnu filtráciu
5. Pripraviť asyn funkcionalitu pre zhrnutie nových článkov do jedného emailu a jeho poslanie odberateľom po uzávierke -
   treba myslieť na performance

## Nice to have

1. Integration tests
2. ...

## Epilogue

1. Reálne netreba rozposielať emaily skrz nejakú SMTP službu, stačí to mocknuť.
2. Ako primárne kľúče používame UUID - je to už pripravené v kostre

## Hints

- project start (see for more info: https://laravel.com/docs/11.x#docker-installation-using-sail)

  ```bash
  $ ./vendor/bin/sail up
  ```
  
- generate migration in doctrine

  ```bash
  $ ./vendor/bin/sail artisan doctrine:migrations:diff
  ```

- apply migration in doctrine

  ```bash
  $ ./vendor/bin/sail artisan doctrine:migrations:migrate
  ```

# Solution

## Instalation

New sail from `https://laravel.com/docs/11.x/installation#docker-installation-using-sail`

## Time & used methods

I have dedicated to this issue around 15 hours of my time.

As one of the most biggest change for me was use ChatGPT as main tool, for creating code and getting know neccessary parts of Laravel and Doctrine.

I also used stackoverflow and generraly internet to get some specific information for the issues I had.

## Seeds

`./vendor/bin/sail artisan db:seed`

## Possible improvements

- I didn't use Doctrine repositories as much as I should, but main difference would be passing into controllers not entityManager, but specific Entity repositories something similar to DatabaseSeeder

- Due to exceeded time frame for this task I did not create Unit tests, but at least I created one test for email sending job  with mock. 

- I probably did not make all places typehinted using PHP 8 annotation, but I used it in most places.