import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
import LanguageDetector from 'i18next-browser-languagedetector';
const resources = {
    en: {
        translation: {
            "Projets": "Projects",
            "Accueil" : "Home",
            "Liste de projets" :"Projects list",
            "Rechercher" : "Search",
            "Localisation" : "localization",
            "Region" : "Region",
            "Département" : "Department",
            "Veuillez choisir une region" :"Choose region",
            "Choisir un département" : "Choose department",
            "Arrondissement" : "District",
            "Choisir un arrondissement" : "Choose district",
            "Tous les secteurs" : "All sector",
            "Maturité du projet" : "Maturity of the project",
            "Affiché" : "Show",
            "sur" : "of",
            "projets trouvés" : "projets found",
            "Aucun projet disponible pour le moment" : "No registered project yet",
            "Télécharger" : "Download",
            "Rechercher Ici" : "Search here",
            "Conseil regional" : "Regional Council",
            "Autres informations" : "Other informations",
            "Elémentts de maturité" : "Maturity element",
            "Status" : "Status",
            "Financement" : "Financement",
            "Ajout projet" : "Added project",
            "Modification projet" : "Updated project",
            "Suivez ces etapes" : "Follow this steps",
            "Présentation du projet" : "Presentation of the project",
            "Intitulé" : "Title",
            "Caracteristique de l\'activité" : "Characteristic of the activity",
            "Marchés cibles" : "Target market",
            "Supply Chain" : "Supply chain",
            "Facteurs et atouts géographiques de production" : "Geographical factors and assets of production",
            "Secteur" : "Sector",
            "Choisir un secteur" : "Choose sector",
            "Objectis" : "Objectives",
            "Position sur le complexe des chaines de valeur ajoutée" : "Position on the value-added chain complex",
            "Eligibilité au bénéfice des appuis et arrangement de l’environnement institutionnel" : "Eligibility for the benefit of support and arrangement of the institutional environment"

        }
    },

    fr : {
        translation: {
            "Projets": "Projects",
            "Acueil" : "Accueil",
            "Liste de projets" :"Liste de projets",
            "Rechercher" : "Rechercher",
            "Localisation" : "Localisation",
            "Region" : "Region",
            "Veuillez choisir une région" :"Veuillez choisir une région",
            "Choisir un departement" : "Choisir un departement",
            "Arrondissement" : "Arrondissement",
            "Choisir un arrondissement" : "Choisir un arrondissement",
            "Tous les secteurs" : "Tous les secteurs",
            "Maturité du projet" : "Maturité du projet",
            "Affiché" : "Affiché",
            "of" : "de",
            "projets trouvés" : "projets trouvés",
            "Aucun projet disponible pour le moment" : "Aucun projet disponible pour le moment",
            "Télécharger" : "Télécharger",
            "Rechercher Ici" : "Rechercher Ici",
            "Conseil regional" : "Conseil regional",
            "sur" : "sur",
           "Autres informations" : "Autres informations",
            "Elémentts de maturité" : "Elémentts de maturité",
            "Status" : "Status",
            "Financement" : "Financement",
            "Ajout projet" : "Ajout projet",
            "Modification projet" : "Modification projet",
            "Suivez ces etapes" : "Suivez ces etapes",
            "Présentation du projet" : "Présentation du projet",
            "Intitulé" : "Intitulé",
            "Caracteristique de l\'activité" : "Caracteristique de l\'activité",
            "Marchés cibles" : "Marchés cibles",
            "Supply Chain" : "Supply Chain",
            "Facteurs et atouts géographiques de production" : "Facteurs et atouts géographiques de production",
            "Secteur" : "Secteur",
            "Choisir un secteur" : "Choisir un secteur",
            "Objectis" : "Objectis",
            "Position sur le complexe des chaines de valeur ajoutée" : "Position sur le complexe des chaines de valeur ajoutée",
            "Eligibilité au bénéfice des appuis et arrangement de l’environnement institutionnel" : "Eligibilité au bénéfice des appuis et arrangement de l’environnement institutionnel,"

        }
    }
};

i18n
    .use(LanguageDetector)
    .use(initReactI18next)
    .init({
        resources,
        lng: 'en',
        fallbackLng: 'en',
        interpolation: {
            escapeValue: false, // not needed for react as it escapes by default
        },
    });

export default i18n;