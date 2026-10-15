<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/remise.php';

final class RemiseTest extends TestCase
{
    public function test_un_montant_nul_donne_une_remise_nulle(): void
    {
        $this->assertSame(0, calculerRemise(0));
    }

    public function test_sous_10000_centimes_aucune_remise(): void
    {
        $this->assertSame(0, calculerRemise(9999));
    }

    public function test_a_partir_de_10000_centimes_remise_de_5_pourcent(): void
    {
        $this->assertSame(500, calculerRemise(10000));
    }

    public function test_la_remise_est_arrondie_au_centime_inferieur(): void
    {
        $this->assertSame(500, calculerRemise(10019));
    }

    public function test_juste_sous_50000_centimes_le_taux_reste_5_pourcent(): void
    {
        $this->assertSame(2499, calculerRemise(49999));
    }

    public function test_a_partir_de_50000_centimes_remise_de_10_pourcent(): void
    {
        $this->assertSame(5000, calculerRemise(50000));
    }

    public function test_juste_sous_200000_centimes_le_taux_reste_10_pourcent(): void
    {
        $this->assertSame(19999, calculerRemise(199999));
    }

    public function test_a_partir_de_200000_centimes_remise_de_15_pourcent(): void
    {
        $this->assertSame(30000, calculerRemise(200000));
    }

    public function test_un_montant_negatif_est_refuse(): void
    {
        $this->expectException(InvalidArgumentException::class);
        calculerRemise(-1);
    }

    public function test_un_montant_non_entier_est_refuse(): void
    {
        $this->expectException(InvalidArgumentException::class);
        calculerRemise(100.5);
    }
}
