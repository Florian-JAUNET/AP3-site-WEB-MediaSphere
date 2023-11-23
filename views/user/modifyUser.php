<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-[calc(100vh-136px)] lg:py-0 container">

    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/2 px-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Modifier vos informations</h1>
            <p class="text-gray-600 mb-6">Remplissez les informations ci-dessous pour modifier votre compte.</p>
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-1/2 px-4 mt-6 md:mt-0">
            <div class="bg-white shadow-lg rounded-lg px-6 py-4">

                <!-- Message d'erreur -->

                <?php if (isset($error)) { ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oups ! </strong>
                        <span class="block sm:inline"><?= $error ?></span>
                    </div>
                <?php } ?>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations personnelles</h2>

                <!-- Formulaire -->
                <form class="max-w-sm" method="post" action="/user/modifyUser">
                    <div class="mb-4">
                        <label for="nom" class="block text-gray-800 font-semibold mb-2">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user -> nomemprunteur) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" require>
                    </div>

                    <div class="mb-4">
                        <label for="prenom" class="block text-gray-800 font-semibold mb-2">Prénom</label>
                        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user -> prenomemprunteur) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" require>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-800 font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user -> emailemprunteur) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" require>
                    </div>

                    <div class="mb-4">
                        <label for="telephone" class="block text-gray-800 font-semibold mb-2">Téléphone</label>
                        <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($user -> telportable) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" require>
                    </div>

                    <!-- <div class="mb-4">
                        <label for="oldPassword" class="block text-gray-800 font-semibold mb-2">Ancien mot de passe</label>
                        <input type="password" id="oldPassword" name="oldPassword" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div> -->

                    <!-- <div class="mb-4">
                        <label for="newPassword" class="block text-gray-800 font-semibold mb-2">Nouveau mot de passe</label>
                        <input type="newPassword" id="newPassword" name="newPassword" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" require>
                    </div> -->

                    <!-- <div class="mb-4">
                        <label for="confirmPassword" class="block text-gray-800 font-semibold mb-2">Confirmer le nouveau mot de passe</label>
                        <input type="confirmPassword" id="confirmPassword" name="confirmPassword" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" require>
                    </div> -->

                    <div class="text-center">
                        <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full" action="/user/modifyUser">
                            Modifier mes informations
                        </button>
                        <!-- Petit texte en gras italique rouge -->
                        <p class="text-red-500 text-xs italic mt-4">Les modifications seront affichées lors de votre prochaine connexion.</p>                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>