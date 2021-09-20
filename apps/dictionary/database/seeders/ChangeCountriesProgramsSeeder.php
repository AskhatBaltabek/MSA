<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Tariff;
use Illuminate\Database\Seeder;

class ChangeCountriesProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ["id" => 665, "country_id" => 17, "title" => "Австралия", "alpha_code" => "AUS", "program_id" => 3],
            ["id" => 673, "country_id" => 27, "title" => "Аргентина", "alpha_code" => "ARG", "program_id" => 3],
            ["id" => 677, "country_id" => 31, "title" => "Багамские острова", "alpha_code" => "BHS", "program_id" => 3],
            ["id" => 679, "country_id" => 33, "title" => "Барбадос", "alpha_code" => "BRB", "program_id" => 3],
            ["id" => 682, "country_id" => 36, "title" => "Белиз", "alpha_code" => "BLZ", "program_id" => 3],
            ["id" => 689, "country_id" => 43, "title" => "Боливия", "alpha_code" => "BOL", "program_id" => 3],
            ["id" => 690, "country_id" => 44, "title" => "Бразилия", "alpha_code" => "BRA", "program_id" => 3],
            ["id" => 695, "country_id" => 50, "title" => "Венесуэла", "alpha_code" => "VEN", "program_id" => 3],
            ["id" => 700, "country_id" => 56, "title" => "Гаити", "alpha_code" => "HTI", "program_id" => 3],
            ["id" => 701, "country_id" => 57, "title" => "Гайана", "alpha_code" => "GUY", "program_id" => 3],
            ["id" => 704, "country_id" => 60, "title" => "Гватемала", "alpha_code" => "GTM", "program_id" => 3],
            ["id" => 708, "country_id" => 64, "title" => "Гондурас", "alpha_code" => "HND", "program_id" => 3],
            ["id" => 709, "country_id" => 65, "title" => "Гренада", "alpha_code" => "GRD", "program_id" => 3],
            ["id" => 716, "country_id" => 72, "title" => "Доминика", "alpha_code" => "DMA", "program_id" => 3],
            ["id" => 717, "country_id" => 73, "title" => "Доминиканская республика", "alpha_code" => "DOM", "program_id" => 3],
            ["id" => 732, "country_id" => 90, "title" => "Канада", "alpha_code" => "CAN", "program_id" => 3],
            ["id" => 736, "country_id" => 94, "title" => "Кирибати", "alpha_code" => "KIR", "program_id" => 3],
            ["id" => 739, "country_id" => 97, "title" => "Колумбия", "alpha_code" => "COL", "program_id" => 3],
            ["id" => 742, "country_id" => 101, "title" => "Коста-Рика", "alpha_code" => "CRI", "program_id" => 3],
            ["id" => 744, "country_id" => 103, "title" => "Куба", "alpha_code" => "CUB", "program_id" => 3],
            ["id" => 758, "country_id" => 122, "title" => "Маршалловы острова", "alpha_code" => "MHL", "program_id" => 3],
            ["id" => 765, "country_id" => 133, "title" => "Науру", "alpha_code" => "NRU", "program_id" => 3],
            ["id" => 768, "country_id" => 137, "title" => "Новая Зеландия", "alpha_code" => "NZL", "program_id" => 3],
            ["id" => 770, "country_id" => 140, "title" => "Никарагуа", "alpha_code" => "NIC", "program_id" => 3],
            ["id" => 771, "country_id" => 141, "title" => "Объединенные Арабские Эмираты", "alpha_code" => "ARE", "program_id" => 1],
            ["id" => 774, "country_id" => 144, "title" => "Палау", "alpha_code" => "PLW", "program_id" => 3],
            ["id" => 775, "country_id" => 146, "title" => "Панама", "alpha_code" => "PAN", "program_id" => 3],
            ["id" => 777, "country_id" => 149, "title" => "Парагвай", "alpha_code" => "PRY", "program_id" => 3],
            ["id" => 778, "country_id" => 150, "title" => "Перу", "alpha_code" => "PER", "program_id" => 3],
            ["id" => 783, "country_id" => 156, "title" => "Эль-Сальвадор", "alpha_code" => "SLV", "program_id" => 3],
            ["id" => 788, "country_id" => 165, "title" => "Сент-Люсия", "alpha_code" => "LCA", "program_id" => 3],
            ["id" => 794, "country_id" => 173, "title" => "Суринам", "alpha_code" => "SUR", "program_id" => 3],
            ["id" => 797, "country_id" => 179, "title" => "Тринидад и Тобаго", "alpha_code" => "TTO", "program_id" => 3],
            ["id" => 812, "country_id" => 197, "title" => "Чили", "alpha_code" => "CHL", "program_id" => 3],
            ["id" => 816, "country_id" => 201, "title" => "Эквадор", "alpha_code" => "ECU", "program_id" => 3],
            ["id" => 822, "country_id" => 207, "title" => "Ямайка", "alpha_code" => "JAM", "program_id" => 3],
            ["id" => 826, "country_id" => 25, "title" => "Антигуа и Барбуда", "alpha_code" => "ATG", "program_id" => 3],
            ["id" => 834, "country_id" => 124, "title" => "Микронезия, Федеративные штаты", "alpha_code" => "FSM", "program_id" => 3],
            ["id" => 836, "country_id" => 147, "title" => "Папуа-Новая Гвинея", "alpha_code" => "PNG", "program_id" => 3],
            ["id" => 839, "country_id" => 164, "title" => "Сент-Китс и Невис", "alpha_code" => "KNA", "program_id" => 3],
            ["id" => 857, "country_id" => 238, "title" => "Сент-Винсент и Гренадины", "alpha_code" => "VCT", "program_id" => 3],
            ["id" => 874, "country_id" => 123, "title" => "Мексика", "alpha_code" => "MEX", "program_id" => 3],
            ["id" => 890, "country_id" => 188, "title" => "Уругвай", "alpha_code" => "URY", "program_id" => 3],
            ["id" => 909, "country_id" => 216, "title" => "Вануату", "alpha_code" => "VUT", "program_id" => 3],
            ["id" => 653, "country_id" => 1, "title" => "Казахстан", "alpha_code" => "KAZ", "program_id" => 2],
            ["id" => 654, "country_id" => 5, "title" => "Германия", "alpha_code" => "DEU", "program_id" => 2],
            ["id" => 655, "country_id" => 6, "title" => "Соединенные Штаты Америки", "alpha_code" => "USA", "program_id" => 3],
            ["id" => 656, "country_id" => 7, "title" => "UK", "alpha_code" => "", "program_id" => 2],
            ["id" => 657, "country_id" => 8, "title" => "Швейцария", "alpha_code" => "CHE", "program_id" => 2],
            ["id" => 658, "country_id" => 10, "title" => "Египет", "alpha_code" => "EGY", "program_id" => 2],
            ["id" => 659, "country_id" => 11, "title" => "Ирландия", "alpha_code" => "IRL", "program_id" => 2],
            ["id" => 660, "country_id" => 12, "title" => "Франция", "alpha_code" => "FRA", "program_id" => 2],
            ["id" => 661, "country_id" => 13, "title" => "Бельгия", "alpha_code" => "BEL", "program_id" => 2],
            ["id" => 662, "country_id" => 14, "title" => "Италия", "alpha_code" => "ITA", "program_id" => 2],
            ["id" => 663, "country_id" => 15, "title" => "Тунис", "alpha_code" => "TUN", "program_id" => 3],
            ["id" => 664, "country_id" => 16, "title" => "Япония", "alpha_code" => "JPN", "program_id" => 2],
            ["id" => 666, "country_id" => 18, "title" => "Австрия", "alpha_code" => "AUT", "program_id" => 2],
            ["id" => 667, "country_id" => 19, "title" => "Азербайджан", "alpha_code" => "AZE", "program_id" => 1],
            ["id" => 668, "country_id" => 20, "title" => "Албания", "alpha_code" => "ALB", "program_id" => 2],
            ["id" => 669, "country_id" => 21, "title" => "Алжир", "alpha_code" => "DZA", "program_id" => 2],
            ["id" => 670, "country_id" => 22, "title" => "Англия", "alpha_code" => "AIA", "program_id" => 1],//
            ["id" => 671, "country_id" => 23, "title" => "Ангола", "alpha_code" => "AGO", "program_id" => 2],
            ["id" => 672, "country_id" => 24, "title" => "Андорра", "alpha_code" => "AND", "program_id" => 2],
            ["id" => 674, "country_id" => 28, "title" => "Армения", "alpha_code" => "ARM", "program_id" => 1],
            ["id" => 675, "country_id" => 29, "title" => "Аруба", "alpha_code" => "ABW", "program_id" => 1],//
            ["id" => 676, "country_id" => 30, "title" => "Афганистан", "alpha_code" => "AFG", "program_id" => 1],
            ["id" => 678, "country_id" => 32, "title" => "Бангладеш", "alpha_code" => "BGD", "program_id" => 1],
            ["id" => 680, "country_id" => 34, "title" => "Бахрейн", "alpha_code" => "BHR", "program_id" => 1],
            ["id" => 681, "country_id" => 35, "title" => "Беларусь", "alpha_code" => "BLR", "program_id" => 1],
            ["id" => 683, "country_id" => 37, "title" => "Бенин", "alpha_code" => "BEN", "program_id" => 3],
            ["id" => 684, "country_id" => 38, "title" => "Бермудские острова", "alpha_code" => "BMU", "program_id" => 1],//
            ["id" => 685, "country_id" => 39, "title" => "Бирма", "alpha_code" => NULL, "program_id" => 1],//
            ["id" => 686, "country_id" => 40, "title" => "Босния и Герцеговина", "alpha_code" => "BIH", "program_id" => 1],
            ["id" => 687, "country_id" => 41, "title" => "Ботсвана", "alpha_code" => "BWA", "program_id" => 3],
            ["id" => 688, "country_id" => 42, "title" => "Болгария", "alpha_code" => "BGR", "program_id" => 2],
            ["id" => 691, "country_id" => 45, "title" => "Буркина-Фасо", "alpha_code" => "BFA", "program_id" => 3],
            ["id" => 692, "country_id" => 46, "title" => "Бурунди", "alpha_code" => "BDI", "program_id" => 3],
            ["id" => 693, "country_id" => 47, "title" => "Бутан", "alpha_code" => "BTN", "program_id" => 1],
            ["id" => 694, "country_id" => 49, "title" => "Венгрия", "alpha_code" => "HUN", "program_id" => 2],
            ["id" => 696, "country_id" => 52, "title" => "Виргинские о-ва (США)", "alpha_code" => "VIR", "program_id" => 1],//
            ["id" => 697, "country_id" => 53, "title" => "Самоа", "alpha_code" => "WSM", "program_id" => 3],
            ["id" => 698, "country_id" => 54, "title" => "Вьетнам", "alpha_code" => "VNM", "program_id" => 2],
            ["id" => 699, "country_id" => 55, "title" => "Габон", "alpha_code" => "GAB", "program_id" => 3],
            ["id" => 702, "country_id" => 58, "title" => "Гамбия", "alpha_code" => "GMB", "program_id" => 3],
            ["id" => 703, "country_id" => 59, "title" => "Гана", "alpha_code" => "GHA", "program_id" => 3],
            ["id" => 705, "country_id" => 61, "title" => "Гвинея", "alpha_code" => "GIN", "program_id" => 3],
            ["id" => 706, "country_id" => 62, "title" => "Гвинея-Бисау", "alpha_code" => "GNB", "program_id" => 3],
            ["id" => 707, "country_id" => 63, "title" => "Гибралтар", "alpha_code" => "GIB", "program_id" => 1],//
            ["id" => 710, "country_id" => 66, "title" => "Гренландия", "alpha_code" => "GRL", "program_id" => 1],//
            ["id" => 711, "country_id" => 67, "title" => "Греция", "alpha_code" => "GRC", "program_id" => 2],
            ["id" => 712, "country_id" => 68, "title" => "Грузия", "alpha_code" => "GEO", "program_id" => 1],
            ["id" => 713, "country_id" => 69, "title" => "Гуам", "alpha_code" => "GUM", "program_id" => 1],//
            ["id" => 714, "country_id" => 70, "title" => "Дания", "alpha_code" => "DNK", "program_id" => 2],
            ["id" => 715, "country_id" => 71, "title" => "Джибути", "alpha_code" => "DJI", "program_id" => 1],//
            ["id" => 718, "country_id" => 74, "title" => "Замбия", "alpha_code" => "ZMB", "program_id" => 3],
            ["id" => 719, "country_id" => 75, "title" => "Американское самоа", "alpha_code" => "ASM", "program_id" => 1],//
            ["id" => 720, "country_id" => 76, "title" => "Зимбабве", "alpha_code" => "ZWE", "program_id" => 3],
            ["id" => 721, "country_id" => 77, "title" => "Израиль", "alpha_code" => "ISR", "program_id" => 2],
            ["id" => 722, "country_id" => 78, "title" => "Индия", "alpha_code" => "IND", "program_id" => 1],
            ["id" => 723, "country_id" => 79, "title" => "Индонезия", "alpha_code" => "IDN", "program_id" => 2],
            ["id" => 724, "country_id" => 80, "title" => "Иордания", "alpha_code" => "JOR", "program_id" => 1],
            ["id" => 725, "country_id" => 81, "title" => "Ирак", "alpha_code" => "IRQ", "program_id" => 2],
            ["id" => 726, "country_id" => 83, "title" => "Исландия", "alpha_code" => "ISL", "program_id" => 2],
            ["id" => 727, "country_id" => 84, "title" => "Испания", "alpha_code" => "ESP", "program_id" => 2],
            ["id" => 728, "country_id" => 85, "title" => "Йемен", "alpha_code" => "YEM", "program_id" => 1],
            ["id" => 729, "country_id" => 86, "title" => "Кабо-Верде", "alpha_code" => "CPV", "program_id" => 3],
            ["id" => 730, "country_id" => 88, "title" => "Камбоджа", "alpha_code" => "KHM", "program_id" => 1],
            ["id" => 731, "country_id" => 89, "title" => "Камерун", "alpha_code" => "CMR", "program_id" => 3],
            ["id" => 733, "country_id" => 91, "title" => "Катар", "alpha_code" => "QAT", "program_id" => 1],
            ["id" => 734, "country_id" => 92, "title" => "Кения", "alpha_code" => "KEN", "program_id" => 3],
            ["id" => 735, "country_id" => 93, "title" => "Кипр", "alpha_code" => "CYP", "program_id" => 2],
            ["id" => 737, "country_id" => 95, "title" => "Китай", "alpha_code" => "CHN", "program_id" => 1],
            ["id" => 738, "country_id" => 96, "title" => "Корея", "alpha_code" => "KOR", "program_id" => 2],
            ["id" => 740, "country_id" => 98, "title" => "Коморские острова", "alpha_code" => "COM", "program_id" => 3],
            ["id" => 741, "country_id" => 99, "title" => "Конго", "alpha_code" => "COG", "program_id" => 3],
            ["id" => 743, "country_id" => 102, "title" => "Кот-Д`ивуар", "alpha_code" => "CIV", "program_id" => 3],
            ["id" => 745, "country_id" => 104, "title" => "Кувейт", "alpha_code" => "KWT", "program_id" => 1],
            ["id" => 746, "country_id" => 108, "title" => "Лесото", "alpha_code" => "LSO", "program_id" => 3],
            ["id" => 747, "country_id" => 110, "title" => "Ливан", "alpha_code" => "LBN", "program_id" => 1],
            ["id" => 748, "country_id" => 111, "title" => "Либерия", "alpha_code" => "LBR", "program_id" => 3],
            ["id" => 749, "country_id" => 112, "title" => "Литва", "alpha_code" => "LTU", "program_id" => 2],
            ["id" => 750, "country_id" => 114, "title" => "Маврикий", "alpha_code" => "MUS", "program_id" => 3],
            ["id" => 751, "country_id" => 115, "title" => "Мадагаскар", "alpha_code" => "MDG", "program_id" => 3],
            ["id" => 752, "country_id" => 116, "title" => "Македония, бывшая Югославская республика", "alpha_code" => "MKD", "program_id" => 2],
            ["id" => 753, "country_id" => 117, "title" => "Малави", "alpha_code" => "MWI", "program_id" => 3],
            ["id" => 754, "country_id" => 118, "title" => "Малайзия", "alpha_code" => "MYS", "program_id" => 2],
            ["id" => 755, "country_id" => 119, "title" => "Мальта", "alpha_code" => "MLT", "program_id" => 2],
            ["id" => 756, "country_id" => 120, "title" => "Мали", "alpha_code" => "MLI", "program_id" => 3],
            ["id" => 757, "country_id" => 121, "title" => "Северные Марианские о-ва", "alpha_code" => "MNP", "program_id" => 1],//
            ["id" => 759, "country_id" => 125, "title" => "Мозамбик", "alpha_code" => "MOZ", "program_id" => 3],
            ["id" => 760, "country_id" => 127, "title" => "Монако", "alpha_code" => "MCO", "program_id" => 2],
            ["id" => 761, "country_id" => 128, "title" => "Монголия", "alpha_code" => "MNG", "program_id" => 1],
            ["id" => 762, "country_id" => 130, "title" => "Марокко", "alpha_code" => "MAR", "program_id" => 3],
            ["id" => 763, "country_id" => 131, "title" => "Мьянма", "alpha_code" => "MMR", "program_id" => 1],
            ["id" => 764, "country_id" => 132, "title" => "Намибия", "alpha_code" => "NAM", "program_id" => 3],
            ["id" => 766, "country_id" => 134, "title" => "Непал", "alpha_code" => "NPL", "program_id" => 1],
            ["id" => 767, "country_id" => 136, "title" => "Нигерия", "alpha_code" => "NGA", "program_id" => 3],
            ["id" => 769, "country_id" => 139, "title" => "Нидерланды", "alpha_code" => "NLD", "program_id" => 2],
            ["id" => 772, "country_id" => 142, "title" => "Оман", "alpha_code" => "OMN", "program_id" => 1],
            ["id" => 773, "country_id" => 143, "title" => "Пакистан", "alpha_code" => "PAK", "program_id" => 1],
            ["id" => 776, "country_id" => 148, "title" => "Новая_Гвинея", "alpha_code" => "", "program_id" => 1],//
            ["id" => 779, "country_id" => 152, "title" => "Польша", "alpha_code" => "POL", "program_id" => 2],
            ["id" => 780, "country_id" => 153, "title" => "Португалия", "alpha_code" => "PRT", "program_id" => 2],
            ["id" => 781, "country_id" => 154, "title" => "Руанда", "alpha_code" => "RWA", "program_id" => 3],
            ["id" => 782, "country_id" => 155, "title" => "Румыния", "alpha_code" => "ROU", "program_id" => 2],
            ["id" => 784, "country_id" => 157, "title" => "Сан-Марино", "alpha_code" => "SMR", "program_id" => 2],
            ["id" => 785, "country_id" => 159, "title" => "Саудовская Аравия", "alpha_code" => "SAU", "program_id" => 1],
            ["id" => 786, "country_id" => 160, "title" => "Свазиленд", "alpha_code" => "SWZ", "program_id" => 3],
            ["id" => 787, "country_id" => 161, "title" => "Сен-Пьер и Микелон", "alpha_code" => "SPM", "program_id" => 1],//
            ["id" => 789, "country_id" => 166, "title" => "Сингапур", "alpha_code" => "SGP", "program_id" => 2],
            ["id" => 790, "country_id" => 167, "title" => "Сирийская Арабская республика", "alpha_code" => "SYR", "program_id" => 1],
            ["id" => 791, "country_id" => 168, "title" => "Словакия", "alpha_code" => "SVK", "program_id" => 2],
            ["id" => 792, "country_id" => 170, "title" => "Соломоновы острова", "alpha_code" => "SLB", "program_id" => 3],
            ["id" => 793, "country_id" => 172, "title" => "Судан", "alpha_code" => "SDN", "program_id" => 3],
            ["id" => 795, "country_id" => 174, "title" => "Сьерра-Леоне", "alpha_code" => "SLE", "program_id" => 3],
            ["id" => 796, "country_id" => 175, "title" => "Таджикистан", "alpha_code" => "TJK", "program_id" => 1],
            ["id" => 798, "country_id" => 181, "title" => "Того", "alpha_code" => "TGO", "program_id" => 3],
            ["id" => 799, "country_id" => 182, "title" => "Тувалу", "alpha_code" => "TUV", "program_id" => 3],
            ["id" => 800, "country_id" => 183, "title" => "Туркменистан", "alpha_code" => "TKM", "program_id" => 1],
            ["id" => 801, "country_id" => 184, "title" => "Уганда", "alpha_code" => "UGA", "program_id" => 3],
            ["id" => 802, "country_id" => 185, "title" => "Украина", "alpha_code" => "UKR", "program_id" => 1],
            ["id" => 803, "country_id" => 186, "title" => "Узбекистан", "alpha_code" => "UZB", "program_id" => 1],
            ["id" => 804, "country_id" => 187, "title" => "Уоллис и Футуна острова", "alpha_code" => "WLF", "program_id" => 1],//
            ["id" => 805, "country_id" => 189, "title" => "Фарерские острова", "alpha_code" => "FRO", "program_id" => 1],//
            ["id" => 806, "country_id" => 190, "title" => "Фиджи", "alpha_code" => "FJI", "program_id" => 3],
            ["id" => 807, "country_id" => 191, "title" => "Филиппины", "alpha_code" => "PHL", "program_id" => 1],
            ["id" => 808, "country_id" => 192, "title" => "Финляндия", "alpha_code" => "FIN", "program_id" => 2],
            ["id" => 809, "country_id" => 193, "title" => "Хорватия", "alpha_code" => "HRV", "program_id" => 1],//
            ["id" => 810, "country_id" => 195, "title" => "Чад", "alpha_code" => "TCD", "program_id" => 3],
            ["id" => 811, "country_id" => 196, "title" => "Чехия", "alpha_code" => "CZE", "program_id" => 2],
            ["id" => 813, "country_id" => 198, "title" => "Швеция", "alpha_code" => "SWE", "program_id" => 2],
            ["id" => 814, "country_id" => 199, "title" => "Шри-Ланка", "alpha_code" => "LKA", "program_id" => 1],
            ["id" => 815, "country_id" => 200, "title" => "Эстония", "alpha_code" => "EST", "program_id" => 2],
            ["id" => 817, "country_id" => 202, "title" => "Экваториальная Гвинея", "alpha_code" => "GNQ", "program_id" => 3],
            ["id" => 818, "country_id" => 203, "title" => "Эритрея", "alpha_code" => "ERI", "program_id" => 3],
            ["id" => 819, "country_id" => 204, "title" => "Эфиопия", "alpha_code" => "ETH", "program_id" => 3],
            ["id" => 820, "country_id" => 205, "title" => "Югославия", "alpha_code" => NULL, "program_id" => 1],//
            ["id" => 821, "country_id" => 206, "title" => "Южно-Африканская Республика", "alpha_code" => "ZAF", "program_id" => 3],
            ["id" => 823, "country_id" => 208, "title" => "SCHENGENER STAATEN", "alpha_code" => NULL, "program_id" => 2],
            ["id" => 824, "country_id" => 100, "title" => "Корея, Демократическая народная республика", "alpha_code" => "PRK", "program_id" => 2],
            ["id" => 825, "country_id" => 209, "title" => "Соединенное Королевство Великобритании и Северной Ирландии", "alpha_code" => "GBR", "program_id" => 1],
            ["id" => 827, "country_id" => 26, "title" => "Антильские о-ва Нидерланды", "alpha_code" => NULL, "program_id" => 1],//
            ["id" => 828, "country_id" => 48, "title" => "Ватикан, Holy See", "alpha_code" => "VAT", "program_id" => 2],
            ["id" => 829, "country_id" => 51, "title" => "Виргинские о-ва (Брит.)", "alpha_code" => "VGB", "program_id" => 1],//
            ["id" => 830, "country_id" => 82, "title" => "Иран, исламская республика", "alpha_code" => "IRN", "program_id" => 1],
            ["id" => 831, "country_id" => 87, "title" => "Каймановы острова", "alpha_code" => "CYM", "program_id" => 1],//
            ["id" => 832, "country_id" => 106, "title" => "Лаосская демократическая народная республика", "alpha_code" => "LAO", "program_id" => 2],
            ["id" => 833, "country_id" => 109, "title" => "Ливийская Арабская Джамахирия", "alpha_code" => "LBY", "program_id" => 2],
            ["id" => 835, "country_id" => 126, "title" => "Молдова республика", "alpha_code" => "MDA", "program_id" => 1],
            ["id" => 837, "country_id" => 158, "title" => "Сан-Томе и Принсипи", "alpha_code" => "STP", "program_id" => 3],
            ["id" => 838, "country_id" => 162, "title" => "Сейшельские острова", "alpha_code" => "SYC", "program_id" => 3],
            ["id" => 840, "country_id" => 176, "title" => "Тайвань, провинция Китая", "alpha_code" => "TWN", "program_id" => 1],//
            ["id" => 841, "country_id" => 178, "title" => "Танзания, объединенная республика", "alpha_code" => "TZA", "program_id" => 3],
            ["id" => 842, "country_id" => 211, "title" => "Палестина", "alpha_code" => "PSE", "program_id" => 2],
            ["id" => 843, "country_id" => 212, "title" => "Черногория", "alpha_code" => "MNE", "program_id" => 1],
            ["id" => 844, "country_id" => 230, "title" => "Аландские о-ва", "alpha_code" => "ALA", "program_id" => 1],//
            ["id" => 845, "country_id" => 231, "title" => "Антарктида", "alpha_code" => "ATA", "program_id" => 1],//
            ["id" => 846, "country_id" => 232, "title" => "Бонэйр, Синт-Эстатиус и Саба", "alpha_code" => "BES", "program_id" => 1],//
            ["id" => 847, "country_id" => 233, "title" => "Гвиана", "alpha_code" => "GUF", "program_id" => 1],//
            ["id" => 848, "country_id" => 234, "title" => "Гернси", "alpha_code" => "GGY", "program_id" => 1],//
            ["id" => 849, "country_id" => 235, "title" => "Конго, Демократическая Республика", "alpha_code" => "COD", "program_id" => 3],
            ["id" => 850, "country_id" => 215, "title" => "Мальдивы", "alpha_code" => "MDV", "program_id" => 2],
            ["id" => 851, "country_id" => 217, "title" => "Гваделупа", "alpha_code" => "GLP", "program_id" => 1],//
            ["id" => 852, "country_id" => 219, "title" => "Западная Сахара", "alpha_code" => "ESH", "program_id" => 1],
            ["id" => 853, "country_id" => 226, "title" => "Абхазия", "alpha_code" => NULL, "program_id" => 1],//
            ["id" => 854, "country_id" => 228, "title" => "Тимор-лесте", "alpha_code" => "TLS", "program_id" => 1],//
            ["id" => 855, "country_id" => 236, "title" => "Реюньон", "alpha_code" => "REU", "program_id" => 1],//
            ["id" => 856, "country_id" => 237, "title" => "Сен-Бартелеми", "alpha_code" => "BLM", "program_id" => 1],//
            ["id" => 858, "country_id" => 239, "title" => "Судан", "alpha_code" => "SDN", "program_id" => 3],
            ["id" => 859, "country_id" => 240, "title" => "Теркс и Кайкос", "alpha_code" => "TCA", "program_id" => 1],//
            ["id" => 860, "country_id" => 241, "title" => "Токелау", "alpha_code" => "TKL", "program_id" => 1],//
            ["id" => 861, "country_id" => 242, "title" => "Французские Южные территории", "alpha_code" => "ATF", "program_id" => 1],//
            ["id" => 862, "country_id" => 243, "title" => "Шпицберген и Ян-Майен", "alpha_code" => "SJM", "program_id" => 1],//
            ["id" => 863, "country_id" => 244, "title" => "Южный Судан", "alpha_code" => "SSD", "program_id" => 1],//
            ["id" => 864, "country_id" => 245, "title" => "о. Буве", "alpha_code" => "BVT", "program_id" => 1],//
            ["id" => 865, "country_id" => 246, "title" => "о. Рождества", "alpha_code" => "CXR", "program_id" => 1],//
            ["id" => 866, "country_id" => 247, "title" => "о. Херд и о-ва Макдональд", "alpha_code" => "HMD", "program_id" => 1],//
            ["id" => 867, "country_id" => 248, "title" => "Британская Территория в Индийском Океане", "alpha_code" => "IOT", "program_id" => 1],//
            ["id" => 868, "country_id" => 249, "title" => "Внешние малые о-ва США", "alpha_code" => "UMI", "program_id" => 1],//
            ["id" => 869, "country_id" => 250, "title" => "Кокосовые о-ва", "alpha_code" => "CCK", "program_id" => 1],//
            ["id" => 870, "country_id" => 9, "title" => "Кыргызстан", "alpha_code" => "KGZ", "program_id" => 1],
            ["id" => 871, "country_id" => 251, "title" => "Кюрасао", "alpha_code" => "CUW", "program_id" => 1],//
            ["id" => 872, "country_id" => 107, "title" => "Латвия", "alpha_code" => "LVA", "program_id" => 2],
            ["id" => 873, "country_id" => 113, "title" => "Лихтенштейн", "alpha_code" => "LIE", "program_id" => 2],
            ["id" => 875, "country_id" => 129, "title" => "Монтсеррат", "alpha_code" => "MSR", "program_id" => 1],//
            ["id" => 876, "country_id" => 135, "title" => "Нигер", "alpha_code" => "NER", "program_id" => 3],
            ["id" => 877, "country_id" => 252, "title" => "Ниуэ", "alpha_code" => "NIU", "program_id" => 1],//
            ["id" => 878, "country_id" => 253, "title" => "Новая Каледония", "alpha_code" => "NCL", "program_id" => 1],//
            ["id" => 879, "country_id" => 138, "title" => "Норвегия", "alpha_code" => "NOR", "program_id" => 2],
            ["id" => 880, "country_id" => 145, "title" => "Панама", "alpha_code" => "PAN", "program_id" => 1],//
            ["id" => 881, "country_id" => 2, "title" => "Российская Федерация", "alpha_code" => "RUS", "program_id" => 1],
            ["id" => 882, "country_id" => 163, "title" => "Сенегал", "alpha_code" => "SEN", "program_id" => 1],//
            ["id" => 883, "country_id" => 210, "title" => "Сербия Республика", "alpha_code" => "SRB", "program_id" => 1],
            ["id" => 884, "country_id" => 254, "title" => "Синт-Мартен", "alpha_code" => "SXM", "program_id" => 1],//
            ["id" => 885, "country_id" => 169, "title" => "Словения", "alpha_code" => "SVN", "program_id" => 2],
            ["id" => 886, "country_id" => 171, "title" => "Сомали", "alpha_code" => "SOM", "program_id" => 3],
            ["id" => 887, "country_id" => 177, "title" => "Таиланд", "alpha_code" => "THA", "program_id" => 3],
            ["id" => 888, "country_id" => 180, "title" => "Тонга", "alpha_code" => "TON", "program_id" => 1],
            ["id" => 889, "country_id" => 3, "title" => "Турция", "alpha_code" => "TUR", "program_id" => 1],
            ["id" => 891, "country_id" => 255, "title" => "Фолклендские о-ва (Мальвинские)", "alpha_code" => "FLK", "program_id" => 1],//
            ["id" => 892, "country_id" => 151, "title" => "Полинезия", "alpha_code" => "PYF", "program_id" => 1],//
            ["id" => 893, "country_id" => 194, "title" => "Центральноафриканская республика", "alpha_code" => "CAF", "program_id" => 1],//
            ["id" => 894, "country_id" => 256, "title" => "Южная Георгия и Южные Сандвичевы о-ва", "alpha_code" => "SGS", "program_id" => 1],//
            ["id" => 895, "country_id" => 105, "title" => "о.Кука", "alpha_code" => "COK", "program_id" => 1],//
            ["id" => 896, "country_id" => 257, "title" => "о-ва Питкэрн", "alpha_code" => "PCN", "program_id" => 1],//
            ["id" => 897, "country_id" => 258, "title" => "о-ва Святой Елены, Вознесения и Тристан-да-Кунья", "alpha_code" => "SHN", "program_id" => 1],//
            ["id" => 898, "country_id" => 259, "title" => "о. Джерси", "alpha_code" => "JEY", "program_id" => 1],//
            ["id" => 899, "country_id" => 4, "title" => "Остров Мэн", "alpha_code" => "IMN", "program_id" => 1],//
            ["id" => 900, "country_id" => 260, "title" => "о. Норфолк", "alpha_code" => "NFK", "program_id" => 1],//
            ["id" => 901, "country_id" => 214, "title" => "Сен-Мартен", "alpha_code" => "MAF", "program_id" => 1],//
            ["id" => 902, "country_id" => 218, "title" => "Гонконг", "alpha_code" => "HKG", "program_id" => 1],//
            ["id" => 903, "country_id" => 220, "title" => "Мавритания", "alpha_code" => "MRT", "program_id" => 3],
            ["id" => 904, "country_id" => 222, "title" => "Макао - Специальный административный регион в Китае", "alpha_code" => "MAC", "program_id" => 1],//
            ["id" => 905, "country_id" => 225, "title" => "Пуэрто-Рико", "alpha_code" => "PRI", "program_id" => 1],//
            ["id" => 906, "country_id" => 227, "title" => "Бруней-даруссалам", "alpha_code" => "BRN", "program_id" => 1],
            ["id" => 907, "country_id" => 229, "title" => "Южная Осетия", "alpha_code" => NULL, "program_id" => 1],
            ["id" => 908, "country_id" => 213, "title" => "Люксембург", "alpha_code" => "LUX", "program_id" => 2],
            ["id" => 910, "country_id" => 221, "title" => "Майотта", "alpha_code" => "MYT", "program_id" => 1],//
            ["id" => 911, "country_id" => 223, "title" => "Мартиника", "alpha_code" => "MTQ", "program_id" => 1],//
            ["id" => 912, "country_id" => 224, "title" => "Нормандские острова", "alpha_code" => NULL, "program_id" => 1]//
        ];

        foreach ($countries as $value) {
            $country = Country::find($value['id']);
            if ($country) {
                $country->program_id = $value['program_id'];
                $country->multiply   = 1;
                $country->update();
            }
        }
    }
}
