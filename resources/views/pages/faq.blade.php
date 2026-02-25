@extends('layouts.app')

@section('title', 'Questions fréquentes')
@section('meta_description', 'Réponses aux questions les plus posées : commande, livraison, retours, paiement, compte Glow Beauty.')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="reveal text-center mb-14" data-delay="0">
        <h1 class="font-display text-3xl md:text-4xl font-bold text-[var(--color-noir)] mb-3">Questions fréquentes</h1>
        <p class="text-gray-600 text-lg">Retrouvez les réponses aux questions les plus posées. Vous ne trouvez pas votre réponse ? <a href="{{ route('contact') }}" class="text-[var(--color-rose)] font-medium hover:underline transition-colors">Contactez-nous</a>.</p>
    </div>

    <div class="space-y-3">
        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="1" open>
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>Comment passer commande ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Parcourez la <a href="{{ route('shop.index') }}" class="text-[var(--color-rose)] hover:underline">boutique</a>, ajoutez les produits souhaités au panier en cliquant sur « Ajouter au panier », puis rendez-vous dans le panier et cliquez sur « Passer la commande ». Renseignez votre adresse de livraison, choisissez le mode de livraison (standard, express ou point relais) et validez. Vous pouvez optionnellement enregistrer votre position GPS pour faciliter le suivi. Après validation, vous accéderez à la page de paiement. Une fois le paiement confirmé, vous recevrez un récapitulatif par email avec le numéro de commande.</p>
            </div>
        </details>

        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="2">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>Quels sont les délais de livraison ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Les délais varient selon le mode choisi : <strong>Livraison standard</strong> : 5 à 7 jours ouvrés. <strong>Express</strong> : 24 à 48 h. <strong>Point relais</strong> : 4 à 6 jours. Ces délais sont indicatifs et s’entendent à compter de l’expédition de votre colis. Vous recevrez un email avec le suivi dès l’envoi. La livraison s’effectue en France métropolitaine.</p>
            </div>
        </details>

        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="3">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>Puis-je retourner un produit ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Oui. Vous disposez de <strong>30 jours</strong> après réception pour retourner un article non utilisé, dans son emballage d’origine. Contactez-nous via le <a href="{{ route('contact') }}" class="text-[var(--color-rose)] hover:underline">formulaire Contact</a> en indiquant le numéro de commande et les articles concernés. Nous vous enverrons les instructions et l’étiquette de retour si applicable. Dès réception et contrôle, le remboursement sera effectué sous 14 jours. Consultez la page <a href="{{ route('shipping') }}" class="text-[var(--color-rose)] hover:underline">Livraison & retours</a> pour le détail de la procédure.</p>
            </div>
        </details>

        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="4">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>La livraison est-elle offerte ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Oui. La livraison est <strong>offerte en France métropolitaine dès {{ number_format(config('shop.free_shipping_threshold', 50), 0) }} €</strong> d’achat (tous modes confondus : standard, express, point relais). En dessous de ce montant, des frais s’appliquent selon le mode choisi (par exemple 5,99 € en standard, 9,99 € en express, 4,99 € en point relais). Le montant du panier est calculé après réduction éventuelle (code promo).</p>
            </div>
        </details>

        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="5">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>Comment utiliser ma position GPS à la commande ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Sur la page « Finaliser la commande », dans le bloc « Localisation pour la livraison », cliquez sur « Utiliser ma position GPS ». Votre navigateur vous demandera l’autorisation d’accéder à votre position ; une fois acceptée, les coordonnées sont enregistrées automatiquement. Elles permettent de faciliter le suivi de votre colis et aident le livreur à vous localiser. L’adresse postale (rue, code postal, ville) reste à renseigner manuellement dans le formulaire. La position GPS est optionnelle.</p>
            </div>
        </details>

        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="6">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>Quels moyens de paiement sont acceptés ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Sur notre site, le paiement est sécurisé. En mode démonstration, une simulation de paiement par carte est proposée. En production, nous acceptons les cartes bancaires (Visa, Mastercard, etc.) via notre prestataire de paiement. Le débit est effectué au moment de la validation de la commande. Aucune donnée de carte n’est stockée sur nos serveurs.</p>
            </div>
        </details>

        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="7">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>Comment suivre ma commande ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Une fois votre commande expédiée, vous recevez un email avec un lien de suivi. Vous pouvez aussi consulter l’historique de vos commandes dans votre espace compte (menu « Mes commandes » après connexion). Le statut de la commande (en attente, payée, expédiée, livrée) y est indiqué.</p>
            </div>
        </details>

        <details class="reveal group bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="8">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-5 font-semibold text-[var(--color-noir)] hover:bg-gray-50/50 transition-colors">
                <span>Puis-je modifier ou annuler ma commande ?</span>
                <span class="text-[var(--color-rose)] group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="px-6 pb-5 pt-0 text-gray-600 border-t border-black/5">
                <p class="pt-4">Une fois la commande validée et payée, le traitement commence rapidement. Pour toute modification ou annulation, contactez-nous au plus tôt via le <a href="{{ route('contact') }}" class="text-[var(--color-rose)] hover:underline">formulaire Contact</a> en indiquant votre numéro de commande. Nous ferons notre possible pour satisfaire votre demande selon l’état d’avancement de la commande.</p>
            </div>
        </details>
    </div>

    <div class="reveal mt-12 text-center" data-delay="0">
        <p class="text-gray-600 mb-4">Une autre question ?</p>
        <a href="{{ route('contact') }}" class="btn-premium-press inline-block px-8 py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300 hover:scale-[1.02]">Nous contacter</a>
    </div>
</div>
@endsection
