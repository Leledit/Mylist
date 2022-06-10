<h3>Sessões</h3>
<a href="<?= URL ?>/Paginas/definirSesao/animes" class="nav-link">
    <div class=" main-session-item <?= $_SESSION['SEGMENT'] == 'ANIMES' ? "selectedSession" : "" ?>">
        Animes
    </div>
</a>

<a href="<?= URL ?>/Paginas/definirSesao/filmes" class="nav-link">
    <div class=" main-session-item  <?= $_SESSION['SEGMENT'] == 'FILMESSERIES' ? "selectedSession" : "" ?>">
        Filmes/series
    </div>
</a>