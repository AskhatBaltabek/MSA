<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->call(ProgramsSeeder::class);
        $this->call(TariffsSeeder::class);
        $this->call(CountiresSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(FranchisesSeeder::class);
        $this->call(InstallmentSeeder::class);
        $this->call(InsurancePeriodSeeder::class);
        $this->call(InsuranceTerritoriesSeeder::class);
        $this->call(OptionsSeeder::class);
        $this->call(ProductOptionsSeeder::class);
        $this->call(ProductsSettingsSeeder::class);
        $this->call(RegionsSeeder::class);
        $this->call(PrintTemplatesSeeder::class);
        $this->call(EsbdFaultCodesSeeder::class);
        $this->call(AlphaCodesForCountriesSeeder::class);
        $this->call(ChangeCountriesProgramsSeeder::class);
        $this->call(ChangeTariffsSeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(AgeExperienceSeeder::class);
        $this->call(VehicleTypeSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
