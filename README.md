# phpbb-ext-bbcode-hide

Extension BBCode Hide améliorée pour phpBB.

## Fonctionnalités principales

- Deux modes d’utilisation :
  - [hide]...[/hide] → le contenu est visible uniquement après avoir posté dans le sujet (hors administrateurs).
  - [hide=guests]...[/hide] → le contenu est caché uniquement aux invités et bots, mais visible par tous les membres connectés.

- Compatibilité : phpBB 3.3.x et supérieur (testé sur phpBB 3.3.12)
- Licence : GPL-2.0-only

## Différences avec l’extension originale

Cette extension est un fork de https://github.com/alfredoramos/hide dont le rôle change :

- Comportement par défaut : nécessite désormais un post dans le sujet pour voir le contenu.
- Ajout du paramètre [hide=guests] pour le mode original (cacher uniquement aux invités et bots).

### Modifications techniques

- Transmission des paramètres au moteur XSL  
  Nous utilisons la méthode get_renderer() introduite dans phpBB 3.3.x afin de passer S_HAS_POSTED et S_IS_ADMIN.  
  Compatibilité : cette extension ne prend pas en charge phpBB 3.2.x et antérieurs.

- Conditions XSL corrigées  
  Les variables sont comparées explicitement (= 1) afin d’éviter le bug XSLT 1.0 où les chaînes "0" sont interprétées comme vraies.

## Installation

1. Copier le contenu du dépôt dans le répertoire :
       ext/noordo/hide/
2. Aller dans Panneau d’administration > Personnalisation > Gérer les extensions et activer Hide.

## Exemple d’utilisation du BBCode

    [hide]Ce texte est visible uniquement par ceux qui ont posté dans le sujet[/hide]

    [hide=guests]Ce texte est visible par tous les membres connectés, caché seulement aux invités[/hide]

## Crédit

- Basé sur l’extension originale https://github.com/alfredoramos/hide
- Adaptations et nouvelles fonctionnalités par https://github.com/noordo
