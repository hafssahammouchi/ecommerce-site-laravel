# Mettre le site Glow Beauty en ligne

Ce guide vous permet d’obtenir un **lien public** à envoyer à votre client pour qu’il voie le site.

---

## Option 1 : Hébergement gratuit (pour démo client) — Railway ou Render

### A. Avec **Railway** (recommandé pour un premier déploiement)

1. **Créer un compte**  
   Rendez-vous sur [railway.app](https://railway.app) et créez un compte (gratuit).

2. **Nouveau projet**
   - Cliquez sur **New Project**.
   - Choisissez **Deploy from GitHub repo** (il faut d’abord mettre votre projet sur GitHub).
   - Si le projet n’est pas sur GitHub : créez un dépôt sur [github.com](https://github.com), puis dans votre dossier projet (PowerShell) :
     ```powershell
     cd "C:\Users\hammouchi\OneDrive\Desktop\pr"
     git init
     git add .
     git commit -m "Initial commit"
     git remote add origin https://github.com/VOTRE_UTILISATEUR/VOTRE_REPO.git
     git branch -M main
     git push -u origin main
     ```
   - Dans Railway, connectez ce dépôt.

3. **Base de données MySQL**
   - Dans le projet Railway : **Add New** → **Database** → **MySQL**.
   - Une fois créée, ouvrez la base et notez : **MYSQL_URL** ou **Host**, **User**, **Password**, **Database**.

4. **Variables d’environnement**
   - Ouvrez le **service** de votre application (le déploiement du code).
   - Onglet **Variables** et ajoutez au minimum :
     - `APP_NAME` = Glow Beauty
     - `APP_ENV` = production
     - `APP_DEBUG` = false
     - `APP_URL` = https://VOTRE-APP.up.railway.app (Railway vous donnera cette URL après le premier déploiement)
     - `APP_KEY` = générez avec `php artisan key:generate --show` en local, puis collez la clé
     - `DB_CONNECTION` = mysql
     - `DB_HOST` = (valeur fournie par Railway pour MySQL)
     - `DB_DATABASE` = (nom de la base)
     - `DB_USERNAME` = (utilisateur)
     - `DB_PASSWORD` = (mot de passe)
     - `SESSION_DRIVER` = database
     - `CACHE_STORE` = database

5. **Build & démarrage**
   - Railway détecte souvent PHP/Laravel. Si besoin, ajoutez un **Nixpacks** ou configurez :
     - Build : `composer install --no-dev && php artisan build` (ou sans `artisan build` si vous n’avez pas de front compilé).
     - Start : `php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT`
   - Ou utilisez un **Dockerfile** (voir section suivante).

6. **Récupérer le lien**
   - Une fois le déploiement réussi, Railway affiche une URL du type :  
     **https://votre-app.up.railway.app**
   - C’est **ce lien** que vous envoyez au client.

---

### B. Avec **Render** (alternative gratuite)

1. Compte sur [render.com](https://render.com).
2. **New** → **Web Service**.
3. Connectez votre dépôt GitHub (même principe : pousser le code sur GitHub d’abord).
4. Environnement : **PHP**.
5. Build : `composer install --no-dev`
6. Start : `php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT`
7. Ajoutez une **Base de données MySQL** (Render propose PostgreSQL par défaut ; pour MySQL, il faut parfois un add-on ou une DB externe).
8. Renseignez les variables d’environnement (comme pour Railway).
9. L’URL fournie par Render (ex. **https://glow-beauty.onrender.com**) est le lien à envoyer au client.

---

## Option 2 : Hébergement mutualisé (OVH, o2switch, etc.)

Beaucoup d’hébergeurs proposent **PHP + MySQL**. Vous uploadez le projet et pointez le domaine vers le dossier public.

1. **Créer une base MySQL** dans l’espace client (nom, utilisateur, mot de passe, hôte).
2. **Upload du projet**
   - Soit par FTP : envoyez tout le projet dans un dossier (ex. `pr`) puis, sur le serveur, le dossier **public** doit être la racine web (souvent en renommant `public` en `www` ou en pointant le domaine vers `pr/public`).
   - Soit en déployant depuis Git si l’hébergeur le permet.
3. **Fichier .env sur le serveur**
   - Créez un `.env` à la racine du projet avec au minimum :
     - `APP_ENV=production`
     - `APP_DEBUG=false`
     - `APP_URL=https://votredomaine.com`
     - `APP_KEY=` (générez avec `php artisan key:generate --show`)
     - Variables `DB_*` selon la base créée.
   - Exécutez en SSH (si disponible) :
     ```bash
     composer install --no-dev --optimize-autoloader
     php artisan migrate --force
     php artisan db:seed --force
     php artisan config:cache
     php artisan route:cache
     php artisan view:cache
     ```
4. **Lien à envoyer au client** : **https://votredomaine.com** (ou l’URL fournie par l’hébergeur).

---

## Checklist avant mise en production

- [ ] `.env` avec `APP_ENV=production` et `APP_DEBUG=false`
- [ ] `APP_URL` = l’URL réelle du site (https://...)
- [ ] `APP_KEY` défini (généré une seule fois)
- [ ] Base MySQL créée et variables `DB_*` remplies
- [ ] `php artisan migrate --force` exécuté
- [ ] `php artisan db:seed --force` exécuté (pour catégories, produits, etc.)
- [ ] Dossier `storage` et `bootstrap/cache` en écriture (chmod 775 ou équivalent)
- [ ] Racine web du serveur = dossier **public** (pas la racine du projet)

---

## Obtenir le lien à envoyer au client

- **Railway / Render** : après le premier déploiement réussi, l’URL affichée (ex. `https://glow-beauty.up.railway.app`) est le lien à envoyer.
- **Hébergement mutualisé** : c’est l’URL de votre domaine (ex. `https://www.glowbeauty.fr`).

Vous pouvez envoyer ce lien par e-mail ou message au client pour qu’il consulte le site en ligne.
