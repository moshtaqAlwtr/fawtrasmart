<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function getAllCurrencies()
    {
        return [
            'AED' => 'درهم إماراتي',
            'AFN' => 'أفغاني',
            'ALL' => 'ليك ألباني',
            'AMD' => 'درام أرميني',
            'ANG' => 'غويلدر الأنتيل الهولندية',
            'AOA' => 'كوانزا أنغولي',
            'ARS' => 'بيزو أرجنتيني',
            'AUD' => 'دولار أسترالي',
            'AWG' => 'فلورين أروبي',
            'AZN' => 'مانات',
            'BAM' => 'مارك بوسني',
            'BBD' => 'دولار بربادوسي',
            'BDT' => 'تاكا بنغلاديشي',
            'BGN' => 'ليف بلغاري',
            'BHD' => 'دينار بحريني',
            'BIF' => 'فرنك بوروندي',
            'BMD' => 'دولار برمودي',
            'BND' => 'دولار بروني',
            'BOB' => 'بوليفيانو',
            'BRL' => 'ريال برازيلي',
            'BSD' => 'دولار باهامي',
            'BWP' => 'بولا بوتسواني',
            'BYN' => 'روبل بيلاروسي',
            'BZD' => 'دولار بليزي',
            'CAD' => 'دولار كندي',
            'CDF' => 'فرنك كونغولي',
            'CHF' => 'فرنك سويسري',
            'CLP' => 'بيزو تشيلي',
            'CNY' => 'يوان صيني',
            'COP' => 'بيزو كولومبي',
            'CRC' => 'كولون كوستاريكي',
            'CUP' => 'بيزو كوبي',
            'CVE' => 'إسكودو الرأس الأخضر',
            'CZK' => 'كرونة تشيكية',
            'DJF' => 'فرنك جيبوتي',
            'DKK' => 'كرونة دنماركية',
            'DOP' => 'بيزو دومينيكاني',
            'DZD' => 'دينار جزائري',
            'EGP' => 'جنيه مصري',
            'ERN' => 'ناكفا إريتري',
            'ETB' => 'بير إثيوبي',
            'EUR' => 'يورو',
            'FJD' => 'دولار فيجي',
            'GBP' => 'جنيه إسترليني',
            'GEL' => 'لاري جورجي',
            'GHS' => 'سيدي غاني',
            'GMD' => 'دلاسي غامبي',
            'GNF' => 'فرنك غيني',
            'GTQ' => 'كتزال غواتيمالي',
            'GYD' => 'دولار غياني',
            'HKD' => 'دولار هونج كونج',
            'HNL' => 'لمبيرة هندوراسية',
            'HRK' => 'كونا كرواتية',
            'HTG' => 'غورد هايتي',
            'HUF' => 'فورنت مجري',
            'IDR' => 'روبية إندونيسية',
            'ILS' => 'شيكل إسرائيلي جديد',
            'INR' => 'روبية هندية',
            'IQD' => 'دينار عراقي',
            'IRR' => 'ريال إيراني',
            'ISK' => 'كرونة آيسلندية',
            'JMD' => 'دولار جامايكي',
            'JOD' => 'دينار أردني',
            'JPY' => 'ين ياباني',
            'KES' => 'شلن كيني',
            'KGS' => 'سوم قيرغستاني',
            'KHR' => 'ريال كمبودي',
            'KMF' => 'فرنك قمري',
            'KPW' => 'وون كوري شمالي',
            'KRW' => 'وون كوري جنوبي',
            'KWD' => 'دينار كويتي',
            'KYD' => 'دولار جزر كايمان',
            'KZT' => 'تنغ كازاخستاني',
            'LAK' => 'كيب لاوي',
            'LBP' => 'ليرة لبنانية',
            'LKR' => 'روبية سريلانكية',
            'LRD' => 'دولار ليبيري',
            'LSL' => 'لوتي ليسوتو',
            'LYD' => 'دينار ليبي',
            'MAD' => 'درهم مغربي',
            'MDL' => 'ليو مولدوفي',
            'MGA' => 'أرياري مدغشقري',
            'MKD' => 'دينار مقدوني',
            'MMK' => 'كيات ميانماري',
            'MNT' => 'توغروغ منغولي',
            'MOP' => 'باتاكا ماكاوية',
            'MRU' => 'أوقية موريتانية',
            'MUR' => 'روبية موريشيوسية',
            'MVR' => 'روفيه مالديفية',
            'MWK' => 'كواشا مالاوية',
            'MXN' => 'بيزو مكسيكي',
            'MYR' => 'رينغيت ماليزي',
            'MZN' => 'متكال موزمبيقي',
            'NAD' => 'دولار ناميبي',
            'NGN' => 'نايرا نيجيري',
            'NIO' => 'قرطبة نيكاراغوا',
            'NOK' => 'كرونة نرويجية',
            'NPR' => 'روبية نيبالية',
            'NZD' => 'دولار نيوزيلندي',
            'OMR' => 'ريال عماني',
            'PAB' => 'بالبوا بنمي',
            'PEN' => 'سول بيروفي',
            'PGK' => 'كينا بابوا غينيا الجديدة',
            'PHP' => 'بيزو فلبيني',
            'PKR' => 'روبية باكستانية',
            'PLN' => 'زلوتي بولندي',
            'PYG' => 'غواراني باراغواي',
            'QAR' => 'ريال قطري',
            'RON' => 'ليو روماني',
            'RSD' => 'دينار صربي',
            'RUB' => 'روبل روسي',
            'RWF' => 'فرنك رواندي',
            'SAR' => 'ريال سعودي',
            'SBD' => 'دولار جزر سليمان',
            'SCR' => 'روبية سيشيلية',
            'SDG' => 'جنيه سوداني',
            'SEK' => 'كرونة سويدية',
            'SGD' => 'دولار سنغافوري',
            'SHP' => 'جنيه سانت هيلينا',
            'SLL' => 'ليون سيراليوني',
            'SOS' => 'شلن صومالي',
            'SRD' => 'دولار سورينامي',
            'SSP' => 'جنيه جنوب السودان',
            'STN' => 'دوبرا ساو تومي وبرينسيبي',
            'SVC' => 'كولون سلفادوري',
            'SYP' => 'ليرة سورية',
            'SZL' => 'ليلانغيني سوازيلندي',
            'THB' => 'باخت تايلندي',
            'TJS' => 'سوموني طاجيكستاني',
            'TMT' => 'منات تركمانستاني',
            'TND' => 'دينار تونسي',
            'TOP' => 'بانغا تونغي',
            'TRY' => 'ليرة تركية',
            'TTD' => 'دولار ترينيداد وتوباغو',
            'TWD' => 'دولار تايواني جديد',
            'TZS' => 'شلن تنزاني',
            'UAH' => 'هريفنيا أوكراني',
            'UGX' => 'شلن أوغندي',
            'USD' => 'دولار أمريكي',
            'UYU' => 'بيزو أوروغواي',
            'UZS' => 'سوم أوزبكستاني',
            'VES' => 'بوليفار فنزويلي',
            'VND' => 'دونغ فيتنامي',
            'VUV' => 'فاتو فانواتو',
            'WST' => 'تالا ساموا',
            'XAF' => 'فرنك وسط أفريقي',
            'XCD' => 'دولار شرق كاريبي',
            'XOF' => 'فرنك غرب أفريقي',
            'XPF' => 'فرنك باسيفيكي',
            'YER' => 'ريال يمني',
            'ZAR' => 'راند جنوب أفريقي',
            'ZMW' => 'كواشا زامبي',
            'ZWL' => 'دولار زيمبابوي'
        ];
    }
}
