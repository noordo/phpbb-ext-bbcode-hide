# phpbb-ext-bbcode-hide

Extension BBCode Hide améliorée pour phpBB.

## Fonctionnalités principales

- Quatre modes d’utilisation :
- `[hide]texte[/hide]`
  → Caché aux membres n’ayant pas posté et aux invités

- `[hide=guests]texte[/hide]`
  → Caché uniquement aux invités/bots, visible à tous les membres connectés

- `[hide=inline]texte[/hide]`
  → Caché aux membres n’ayant pas posté et aux invités, s’affiche “en ligne”

- `[hide=guests-inline]texte[/hide]` ou `[hide=inline-guests]texte[/hide]`
  → Caché uniquement aux invités/bots, affiché “en ligne” pour les membres connectés

**A noter la présence nécessaire du trait d'union quand on veut guests et inline simultanément.

- Compatibilité : phpBB 3.3.x et supérieur (testé sur phpBB 3.3.12)
- Licence : GPL-2.0-only

## Différences avec l’extension originale

Cette extension est un fork de https://github.com/alfredoramos/hide dont le rôle change :

- Comportement par défaut : nécessite désormais un post dans le sujet pour voir le contenu.
- Ajout du paramètre [hide=guests] pour le mode original (cacher uniquement aux invités et bots).
- Le mode inline est maintenu mais il se présente différement : cf. exemples.

## Installation

1. Copier le contenu du dépôt dans le répertoire :
       ext/noordo/hide/
2. Aller dans "Panneau d’administration > Personnaliser > Gestion des extensions" et activer Hide.

## Exemple d’utilisation du BBCode

    [hide]Ce texte est visible uniquement par ceux qui ont posté dans le sujet[/hide]

    Je cache un [hide=inline]mot[/hide] dans cette phrase qui n'est visible que par ceux qui ont posté dans le sujet.

    [hide=guests]Ce texte est visible par tous les membres connectés, caché seulement aux invités[/hide]

    Je cache un [hide=inline-guests]mot[/hide] dans cette phrase aux invités non connectés.

## Crédit

- Basé sur l’extension originale https://github.com/alfredoramos/hide
- Adaptations et nouvelles fonctionnalités par https://github.com/noordo
