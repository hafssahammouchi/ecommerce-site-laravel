# Lien pour que le client voie le projet (Railway, sans MySQL)

## Lien public (après déploiement)

**https://ecommerce-site-laravel-production.up.railway.app**

---

Aucune base de données à créer. Il suffit de mettre les variables sur Railway et de redéployer.

---

## 1. Variables sur Railway

Dans **Railway** → votre service (le site Laravel) → **Variables** :

- Soit copier-coller les lignes du fichier **`railway-variables.txt`** (à la racine du projet, généré automatiquement avec une `APP_KEY`).
- Soit ajouter manuellement les 6 variables ci-dessous.

| Variable        | Valeur |
|-----------------|--------|
| `APP_KEY`       | *(généré dans railway-variables.txt ou étape 2)* |
| `APP_URL`       | `https://ecommerce-site-laravel-production.up.railway.app` |
| `APP_ENV`       | `production` |
| `APP_DEBUG`     | `false` |
| `DB_CONNECTION` | `sqlite` |
| `DB_DATABASE`   | `database/database.sqlite` |

**Ne pas créer** de service MySQL. Supprimer les variables MySQL si présentes (`DB_HOST`, etc.).

---

## 2. Générer APP_KEY (une fois)

Sur votre PC, dans le dossier du projet :

```powershell
cd "C:\Users\hammouchi\OneDrive\Desktop\pr"
php artisan key:generate --show
```

Copiez le résultat (ex. `base64:xxxx...`) et collez-le dans la variable **APP_KEY** sur Railway.

---

## 3. Déployer

- Si le code est déjà connecté (GitHub + Railway), faites **Redeploy** après avoir ajouté les variables.
- Sinon : poussez le code sur GitHub, connectez le dépôt à Railway, ajoutez les variables ci-dessus, puis déployez.

---

## 4. Lien pour le client

Après un déploiement réussi, Railway affiche l’URL du site, par exemple :

**https://ecommerce-site-laravel-production.up.railway.app**

Envoyez **ce lien** au client pour qu’il voie le projet. Aucune base de données à gérer.
