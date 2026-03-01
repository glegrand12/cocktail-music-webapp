# CLAUDE.md - Cocktail Music WordPress Project

## Projet

Création d'un site WordPress pour **Cocktail Music**, une entreprise événementielle spécialisée dans les groupes de musique live pour événements festifs (festivals, fêtes locales, bars, événements corporate, événements privés).

---

## Objectif principal

Générer des leads via :
- Formulaire de demande de devis (présent sur chaque page)
- Contact direct par email
- Contact direct par téléphone

---

## Identité visuelle

### Palette "Sunset Session"

```css
:root {
  --color-primary: #2B2D42;      /* Indigo Soir - Fond principal */
  --color-accent: #EF8354;       /* Pêche - Accent principal */
  --color-light: #FFF8F0;        /* Crème Soleil - Textes sur fond sombre */
  --color-secondary: #9D8CA1;    /* Lavande - Accent secondaire */
  --color-muted: #6C6F7D;        /* Gris Doux - Textes secondaires */
  --color-surface: #F5F2ED;      /* Fond alternatif pour sections */
}
```

### Typographie

- **Titres** : Georgia, serif (font-weight: 700)
- **Corps** : system-ui, -apple-system, sans-serif (font-weight: 400-600)
- **Pas de Google Fonts** pour la performance

### Règles de design

- Design sobre et simple
- Pas de gradient
- Pas d'emoji
- Pas de bordures arrondies excessives (max 8px)
- Espacements généreux
- Hiérarchie visuelle claire

---

## Structure des pages

### 1. Page Accueil

**Sections obligatoires :**

1. **Hero Section**
   - Fond : `--color-primary`
   - Titre principal avec mot-clé en `--color-accent`
   - Sous-titre descriptif
   - 2 boutons : "Demander un devis gratuit" (accent) + "Découvrir nos groupes" (outline)
   - Éléments décoratifs : cercles floutés en arrière-plan (opacity 0.1)

2. **Section Statistiques**
   - Fond : `--color-light`
   - 4 colonnes : 15+ années, 500+ événements, 50+ artistes, 100% satisfaits
   - Chiffres en `--color-accent`, labels en `--color-muted`

3. **Section Services (aperçu)**
   - Fond : `--color-surface`
   - Titre : "Une musique pour chaque occasion"
   - 3 cartes : Festivals, Fêtes locales, Bars & Restaurants
   - Chaque carte : icône circulaire, titre, description

4. **Section CTA**
   - Fond : `--color-primary`
   - Titre incitatif
   - Bouton vers formulaire devis

5. **Formulaire de devis**
   - Voir section dédiée

---

### 2. Page Secteurs d'activité

**Sections obligatoires :**

1. **Hero**
   - Fond : `--color-primary`
   - Titre : "Nos secteurs d'activité"

2. **Liste des secteurs** (5 secteurs en alternance gauche/droite)
   - Festivals & Concerts
   - Fêtes locales & Kermesses
   - Bars & Restaurants
   - Événements d'entreprise
   - Événements privés
   
   Chaque secteur :
   - Titre
   - Description (2-3 phrases)
   - Tags des caractéristiques (badges arrondis)
   - Zone image placeholder

3. **Section CTA**
   - Fond : `--color-accent`
   - Message : "Votre événement ne rentre pas dans ces cases ?"
   - Bouton vers devis

4. **Formulaire de devis**

---

### 3. Page Histoire & Valeurs

**Sections obligatoires :**

1. **Hero**
   - Fond : `--color-primary`
   - Titre : "Notre histoire & nos valeurs"

2. **Section Histoire**
   - Fond : `--color-light`
   - Texte narratif (3 paragraphes)
   - Largeur max : 800px, centré

3. **Timeline**
   - Fond : `--color-surface`
   - 4 étapes : 2010 (Création), 2014 (Expansion), 2018 (10 000h), 2023 (50 artistes)
   - Ligne verticale en `--color-accent`

4. **Section Valeurs**
   - Fond : `--color-light`
   - 6 valeurs en grille 3 colonnes :
     - Convivialité
     - Authenticité
     - Accessibilité
     - Professionnalisme
     - Proximité
     - Passion
   - Chaque valeur : icône circulaire, titre, description

5. **Formulaire de devis**

---

### 4. Page Contact

**Sections obligatoires :**

1. **Hero**
   - Fond : `--color-primary`
   - Titre : "Contactez-nous"

2. **Options de contact** (3 colonnes)
   - Téléphone : 06 12 34 56 78
   - Email : contact@cocktailmusic.fr
   - Réseaux : @cocktailmusic
   - Chaque option : titre, valeur, description, bouton d'action

3. **Informations pratiques** (2 colonnes sur fond primary)
   - Zone d'intervention : Hauts-de-France
   - Délais de réservation : 2-3 mois (6 mois pour grands événements)

4. **Formulaire de devis**

---

## Formulaire de demande de devis

**Présent sur TOUTES les pages** (ancre : `#devis-section`)

### Champs requis

| Champ | Type | Placeholder |
|-------|------|-------------|
| Nom complet | text | Jean Dupont |
| Email | email | jean@exemple.fr |
| Téléphone | tel | 06 12 34 56 78 |
| Type d'événement | select | Festival, Bar, Fête locale, Entreprise, Privé, Autre |
| Date souhaitée | date | - |
| Lieu | text | Ville ou adresse |
| Message | textarea | Décrivez votre projet... |

### Style des inputs

```css
input, select, textarea {
  width: 100%;
  padding: 14px 16px;
  border: 1px solid rgba(43, 45, 66, 0.2);
  border-radius: 4px;
  font-size: 14px;
  background-color: var(--color-light);
}
```

---

## Navigation

### Header (fixe)

- Logo : "Cocktail" (light) + "Music" (accent)
- Liens : Accueil, Secteurs d'activité, Histoire & Valeurs, Contact
- Bouton CTA : "Demander un devis" (toujours visible)
- Fond : `--color-primary`
- Lien actif : souligné en `--color-accent`

### Footer

- 4 colonnes : Logo + description, Navigation, Contact, Réseaux sociaux
- Fond : `--color-primary`
- Ligne de copyright en bas

---

## Composants réutilisables

### Bouton Principal

```css
.btn-primary {
  background-color: var(--color-accent);
  color: var(--color-light);
  padding: 16px 32px;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
}
```

### Bouton Secondaire (outline)

```css
.btn-secondary {
  background-color: transparent;
  color: var(--color-light);
  padding: 16px 32px;
  border: 2px solid var(--color-light);
  border-radius: 4px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
}
```

### Badge/Tag

```css
.badge {
  background-color: var(--color-surface);
  color: var(--color-primary);
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}
```

### Carte de service

```css
.service-card {
  background-color: var(--color-light);
  padding: 40px;
  border-radius: 8px;
}
```

---

## Espacements

```css
/* Sections */
--section-padding: 100px 48px;
--section-padding-small: 64px 48px;

/* Conteneur */
--container-max-width: 1200px;

/* Gaps */
--gap-large: 48px;
--gap-medium: 32px;
--gap-small: 16px;
```

---

## Responsive (breakpoints)

```css
/* Desktop : > 1024px */
/* Tablet : 768px - 1024px */
/* Mobile : < 768px */
```

Adaptations mobile :
- Navigation : menu hamburger
- Grilles : passage en 1 colonne
- Padding sections : 60px 24px
- Taille titres : réduire de 20-30%

---

## WordPress - Plugins recommandés

1. **Formulaire** : Contact Form 7 ou WPForms
2. **Page Builder** : Elementor (version gratuite suffisante)
3. **SEO** : Yoast SEO
4. **Performance** : LiteSpeed Cache ou WP Rocket
5. **Sécurité** : Wordfence

---

## SEO - Meta données

### Accueil
- Title : "Cocktail Music | Groupes de musique live pour vos événements"
- Description : "Festivals, fêtes locales, bars, entreprises... Cocktail Music anime vos événements avec des groupes de musique live. Devis gratuit."

### Secteurs
- Title : "Nos secteurs d'activité | Cocktail Music"
- Description : "Découvrez nos prestations musicales pour festivals, fêtes locales, bars, événements d'entreprise et privés."

### Histoire
- Title : "Notre histoire & nos valeurs | Cocktail Music"
- Description : "Depuis 2010, Cocktail Music rassemble les gens autour de la musique live. Découvrez notre histoire et nos valeurs."

### Contact
- Title : "Contact | Cocktail Music"
- Description : "Contactez Cocktail Music pour votre événement. Devis gratuit sous 48h. Téléphone, email ou formulaire en ligne."

---

## Checklist avant livraison

- [ ] Toutes les pages sont créées et fonctionnelles
- [ ] Formulaire de devis testé (envoi email)
- [ ] Navigation fonctionnelle
- [ ] Site responsive (mobile, tablet, desktop)
- [ ] Couleurs conformes à la palette
- [ ] Liens téléphone et email cliquables
- [ ] Images optimisées (WebP, lazy loading)
- [ ] Meta SEO renseignées
- [ ] Favicon installé
- [ ] HTTPS activé
- [ ] Mentions légales / RGPD

---

## Informations de contact à utiliser

- **Téléphone** : 06 12 34 56 78
- **Email** : contact@cocktailmusic.fr
- **Zone** : Hauts-de-France
- **Réseaux** : Facebook, Instagram, YouTube (@cocktailmusic)