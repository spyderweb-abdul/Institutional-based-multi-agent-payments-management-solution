// JavaScript Document
function SelectSubCat3(){
// ON selection of category this function will work

removeAllOptions(document.drop_list.lga);

if(document.drop_list.State.value == 'Abuja')
{
addOption(document.drop_list.lga,"Gwagwalada", "Gwagwalada");
addOption(document.drop_list.lga,"Kuje", "Kuje");
addOption(document.drop_list.lga,"Abaji", "Abaji");
addOption(document.drop_list.lga,"Abuja Municipal", "Abuja Municipal");
addOption(document.drop_list.lga,"Bwari", "Bwari");
addOption(document.drop_list.lga,"Kwali", "Kwali");
}

if(document.drop_list.State.value == 'Abia')
{
addOption(document.drop_list.lga,"Aba-North", "Aba-North");
addOption(document.drop_list.lga,"Aba-South", "Aba-South");
addOption(document.drop_list.lga,"Arochukwu", "Arochukwu");
addOption(document.drop_list.lga,"Bende", "Bende");
addOption(document.drop_list.lga,"Ikwuano", "Ikwuano");
addOption(document.drop_list.lga,"Isiala-Ngwa North", "Isiala-Ngwa North");
addOption(document.drop_list.lga,"Isiala-Ngwa South", "Isiala-Ngwa South");
addOption(document.drop_list.lga,"Isuikwato", "Isuikwato");
addOption(document.drop_list.lga,"Obi Nwa", "Obi Nwa");
addOption(document.drop_list.lga,"Ohafia", "Ohafia");
addOption(document.drop_list.lga,"Osisioma", "Osisioma");
addOption(document.drop_list.lga,"Ngwa", "Ngwa");
addOption(document.drop_list.lga,"Ugwunagbo", "Ugwunagbo");
addOption(document.drop_list.lga,"Ukwa East", "Ukwa-East");
addOption(document.drop_list.lga,"Ukwa West", "Ukwa West");
addOption(document.drop_list.lga,"Umuahia-North", "Umuahia-North");
addOption(document.drop_list.lga,"Umuahia-South", "Umuahia-South");
addOption(document.drop_list.lga,"Umu-Neochi", "Umu-Neochi");

}
if(document.drop_list.State.value == 'Adamawa')
{
addOption(document.drop_list.lga,"Demsa", "Demsa");
addOption(document.drop_list.lga,"Fufore", "Fufore");
addOption(document.drop_list.lga,"Ganaye", "Ganaye");
addOption(document.drop_list.lga,"Gireri", "Gireri");
addOption(document.drop_list.lga,"Gombi", "Gombi");
addOption(document.drop_list.lga,"Guyuk", "Guyuk");
addOption(document.drop_list.lga,"Hong", "Hong");
addOption(document.drop_list.lga,"Jada", "Jada");
addOption(document.drop_list.lga,"Lamurde", "Lamurde");
addOption(document.drop_list.lga,"Madagali", "Madagali");
addOption(document.drop_list.lga,"Maiha", "Maiha");
addOption(document.drop_list.lga,"Mayo-Belwa", "Mayo-Belwa");
addOption(document.drop_list.lga,"Michika", "Michika");
addOption(document.drop_list.lga,"Mubi-North", "Mubi-North");
addOption(document.drop_list.lga,"Mubi-South", "Mubi-South");
addOption(document.drop_list.lga,"Numan", "Numan");
addOption(document.drop_list.lga,"Shelleng", "Shelleng");
addOption(document.drop_list.lga,"Song", "Song");
addOption(document.drop_list.lga,"Toungo", "Toungo");
addOption(document.drop_list.lga,"Yola-North", "Yola-North");
addOption(document.drop_list.lga,"Yola-South", "Yola-South");
}

if(document.drop_list.State.value == 'Akwa Ibom')
{
addOption(document.drop_list.lga,"Abak", "Abak");
addOption(document.drop_list.lga,"Eastern Obolo", "Eastern Obolo");
addOption(document.drop_list.lga,"Eket", "Eket");
addOption(document.drop_list.lga,"Esit Eket", "Esit Eket");
addOption(document.drop_list.lga,"Essien Udim", "Essien Udim");
addOption(document.drop_list.lga,"Etim Ekpo", "Etim Ekpo");
addOption(document.drop_list.lga,"Etinan", "Etinan");
addOption(document.drop_list.lga,"Ibeno", "Ibeno");
addOption(document.drop_list.lga,"Ibesikpo Asutan", "Ibesikpo Asutan");
addOption(document.drop_list.lga,"Ibiono Ibom", "Ibiono Ibom");
addOption(document.drop_list.lga,"Ika", "Ika");
addOption(document.drop_list.lga,"Ikono", "Ikono");
addOption(document.drop_list.lga,"Ikot Abasi", "Ikot Abasi");
addOption(document.drop_list.lga,"Ikot Ekpene", "Ikot Ekpene");
addOption(document.drop_list.lga,"Ini", "Ini");
addOption(document.drop_list.lga,"Itu", "Itu");
addOption(document.drop_list.lga,"Mbo", "Mbo");
addOption(document.drop_list.lga,"Mkpat Enin", "Mkpat Enin");
addOption(document.drop_list.lga,"Nsit Atai", "Nsit Atai");

addOption(document.drop_list.lga,"Nsit Ibom", "Nsit Ibom");
addOption(document.drop_list.lga,"Nsit Ubium", "Nsit Ubium");
addOption(document.drop_list.lga,"Obot Akara", "Obot Akara");
addOption(document.drop_list.lga,"Okobo", "Okobo");
addOption(document.drop_list.lga,"Onna", "Onna");
addOption(document.drop_list.lga,"Oron", "Oron");
addOption(document.drop_list.lga,"Oruk Anam", "Oruk Anam");
addOption(document.drop_list.lga,"Udung Uko", "Udung Uko");
addOption(document.drop_list.lga,"Ukanafun", "Ukanafun");
addOption(document.drop_list.lga,"Uruan", "Uruan");
addOption(document.drop_list.lga,"Urue-Offong/Oruko", "Urue-Offong/Oruko");
addOption(document.drop_list.lga,"Uyo", "Uyo");
}

if(document.drop_list.State.value == 'Anambra')
{
addOption(document.drop_list.lga,"Aguata", "Aguata");
addOption(document.drop_list.lga,"Anambra-East", "Anambra-East");
addOption(document.drop_list.lga,"Anambra-West", "Anambra-West");
addOption(document.drop_list.lga,"Anaocha", "Anaocha");
addOption(document.drop_list.lga,"Awka-North", "Awka-North");
addOption(document.drop_list.lga,"Awka-South", "Awka-South");
addOption(document.drop_list.lga,"Ayamelum", "Ayamelum");
addOption(document.drop_list.lga,"Dunukofia", "Dunukofia");
addOption(document.drop_list.lga,"Ekwusigo", "Ekwusigo");
addOption(document.drop_list.lga,"Idemili-North", "Idemili-North");
addOption(document.drop_list.lga,"Idemili-South", "Idemili-South");
addOption(document.drop_list.lga,"Ihiala", "Ihiala");
addOption(document.drop_list.lga,"Njikoka", "Njikoka");
addOption(document.drop_list.lga,"Nnewi-North", "Nnewi-North");
addOption(document.drop_list.lga,"Nnewi-South", "Nnewi-South");
addOption(document.drop_list.lga,"Ogbaru", "Ogbaru");
addOption(document.drop_list.lga,"Onitsha-North", "Onitsha-North");
addOption(document.drop_list.lga,"Onitsha-South", "Onitsha-South");
addOption(document.drop_list.lga,"Orumba-North", "Orumba-North");
addOption(document.drop_list.lga,"Orumba-South", "Orumba-South");
addOption(document.drop_list.lga,"Oyi", "Oyi");
}

if(document.drop_list.State.value == 'Bauchi')
{
addOption(document.drop_list.lga,"Alkaleri", "Alkaleri");
addOption(document.drop_list.lga,"Bauchi", "Bauchi");
addOption(document.drop_list.lga,"Bogoro", "Bogoro");
addOption(document.drop_list.lga,"Dambari", "Dambari");
addOption(document.drop_list.lga,"Darazo", "Darazo");
addOption(document.drop_list.lga,"Dass", "Dass");
addOption(document.drop_list.lga,"Ganjuwa", "Ganjuwa");
addOption(document.drop_list.lga,"Giade", "Giade");
addOption(document.drop_list.lga,"Itas/Gadau", "Itas/Gadau");
addOption(document.drop_list.lga,"Jama'are", "Jama'are");
addOption(document.drop_list.lga,"Katagum", "Katagum");
addOption(document.drop_list.lga,"Kirfi", "Kirfi");
addOption(document.drop_list.lga,"Misau", "Misau");
addOption(document.drop_list.lga,"Ningi", "Ningi");
addOption(document.drop_list.lga,"Shira", "Shira");
addOption(document.drop_list.lga,"Tafawa-Balewa", "Tafawa-Balewa");
addOption(document.drop_list.lga,"Toro", "Toro");
addOption(document.drop_list.lga,"Warji", "Warji");
addOption(document.drop_list.lga,"Zaki", "Zaki");
}

if(document.drop_list.State.value == 'Bayelsa')
{
addOption(document.drop_list.lga,"Brass", "Brass");
addOption(document.drop_list.lga,"Ekeremor", "Ekeremor");
addOption(document.drop_list.lga,"Kolokuma/Opokuma", "Kolokuma/Opokuma");
addOption(document.drop_list.lga,"Nembe", "Nembe");
addOption(document.drop_list.lga,"Ogbia", "Ogbia");
addOption(document.drop_list.lga,"Sagbama", "Sagbama");
addOption(document.drop_list.lga,"Southern Jaw", "Southern Jaw");
addOption(document.drop_list.lga,"Yenegoa", "Yenegoa");
}

if(document.drop_list.State.value == 'Benue')
{
addOption(document.drop_list.lga,"Ado", "Ado");
addOption(document.drop_list.lga,"Agatu", "Agatu");
addOption(document.drop_list.lga,"Apa", "Apa");
addOption(document.drop_list.lga,"Buruku", "Buruku");
addOption(document.drop_list.lga,"Gboko", "Gboko");
addOption(document.drop_list.lga,"Guma", "Guma");
addOption(document.drop_list.lga,"Gwer-East", "Gwer-East");
addOption(document.drop_list.lga,"Gwer-West", "Gwer-West");
addOption(document.drop_list.lga,"Katsina-Ala", "Katsina-Ala");
addOption(document.drop_list.lga,"Konshisha", "Konshisha");
addOption(document.drop_list.lga,"Kwande", "Kwande");
addOption(document.drop_list.lga,"Logo", "Logo");
addOption(document.drop_list.lga,"Makurdi", "Makurdi");
addOption(document.drop_list.lga,"Obi", "Obi");
addOption(document.drop_list.lga,"Ogbadibo", "Ogbadibo");
addOption(document.drop_list.lga,"Oju", "Oju");
addOption(document.drop_list.lga,"Okpokwu", "Okpokwu");
addOption(document.drop_list.lga,"Ohimini", "Ohimini");
addOption(document.drop_list.lga,"Oturkpo", "Oturkpo");
addOption(document.drop_list.lga,"Tarka", "Tarka");
addOption(document.drop_list.lga,"Ukum", "Ukum");
addOption(document.drop_list.lga,"Ushongo", "Ushongo");
addOption(document.drop_list.lga,"Vandeikya", "Vandeikya");
}

if(document.drop_list.State.value == 'Borno')
{
addOption(document.drop_list.lga,"Abadam", "Abadam");
addOption(document.drop_list.lga,"Askira/Uba", "Askira/Uba");
addOption(document.drop_list.lga,"Bama", "Bama");
addOption(document.drop_list.lga,"Bayo", "Bayo");
addOption(document.drop_list.lga,"Biu", "Biu");
addOption(document.drop_list.lga,"Chibok", "Chibbok");
addOption(document.drop_list.lga,"Damboa", "Damboa");
addOption(document.drop_list.lga,"Dikwa", "Dikwa");
addOption(document.drop_list.lga,"Gubio", "Gubio");
addOption(document.drop_list.lga,"Guzamala", "Guzamala");
addOption(document.drop_list.lga,"Gwoza", "Gwoza");
addOption(document.drop_list.lga,"Hawul", "Hawul");
addOption(document.drop_list.lga,"Jere", "Jere");
addOption(document.drop_list.lga,"Kaga", "Kaga");
addOption(document.drop_list.lga,"Kala/Balge", "Kala/Balge");
addOption(document.drop_list.lga,"Konduga", "Konduga");
addOption(document.drop_list.lga,"Kukawa", "Kukawa");
addOption(document.drop_list.lga,"Kwaya Kusar", "Kwaya Kusar");
addOption(document.drop_list.lga,"Mafa", "Mafa");
addOption(document.drop_list.lga,"Magumeri", "Magumeri");
addOption(document.drop_list.lga,"Maiduguri", "Maiduguri");
addOption(document.drop_list.lga,"Marte", "Marte");
addOption(document.drop_list.lga,"Mobbar", "Mobbar");
addOption(document.drop_list.lga,"Monguno", "Monguno");
addOption(document.drop_list.lga,"Ngala", "Ngala");
addOption(document.drop_list.lga,"Nganzai", "Nganzai");
addOption(document.drop_list.lga,"Shani", "Shani");
}

if(document.drop_list.State.value == 'Cross River')
{
addOption(document.drop_list.lga,"Akpabuyo", "Akpabuyo");
addOption(document.drop_list.lga,"Odukpani", "Odukpani");
addOption(document.drop_list.lga,"Akamkpa", "Akamkpa");
addOption(document.drop_list.lga,"Biase", "Biase");
addOption(document.drop_list.lga,"Abi", "Abi");
addOption(document.drop_list.lga,"Ikom", "Ikom");
addOption(document.drop_list.lga,"Yarkur", "Yarkur");
addOption(document.drop_list.lga,"Odubra", "Odubra");
addOption(document.drop_list.lga,"Boki", "Boki");
addOption(document.drop_list.lga,"Ogoja", "Ogoja");
addOption(document.drop_list.lga,"Yala", "Yala");
addOption(document.drop_list.lga,"Obanliku", "Obanliku");
addOption(document.drop_list.lga,"Obudu", "Obudu");
addOption(document.drop_list.lga,"Calabar-South", "Calabar-South");
addOption(document.drop_list.lga,"Etung", "Etung");
addOption(document.drop_list.lga,"Bekwara", "Bekwara");
addOption(document.drop_list.lga,"Bakassi", "Bakassi");
addOption(document.drop_list.lga,"Calabar Municipality", "Calabar Municipality");
}

if(document.drop_list.State.value == 'Delta')
{
addOption(document.drop_list.lga,"Oshimili", "Oshimili");
addOption(document.drop_list.lga,"Aniocha", "Aniocha");
addOption(document.drop_list.lga,"Aniocha-South", "Aniocha-South");
addOption(document.drop_list.lga,"Ika-South", "Ika-South");
addOption(document.drop_list.lga,"Ika North-East", "Ika North-East");
addOption(document.drop_list.lga,"Ndokwa West", "Ndokwa West");
addOption(document.drop_list.lga,"Ndokwa East", "Ndokwa East");
addOption(document.drop_list.lga,"Isoko-South", "Isoko-South");
addOption(document.drop_list.lga,"Isoko-North", "Isoko-North");
addOption(document.drop_list.lga,"Bomadi", "Bomadi");
addOption(document.drop_list.lga,"Burutu", "Burutu");
addOption(document.drop_list.lga,"Ughelli-South", "Ughelli-South");
addOption(document.drop_list.lga,"Ughelli-North", "Ughelli-North");
addOption(document.drop_list.lga,"Ethiope-West", "Ethiope-West");
addOption(document.drop_list.lga,"Ethiope-East", "Ethiope-East");
addOption(document.drop_list.lga,"Sapele", "Sapele");
addOption(document.drop_list.lga,"Okpe", "Okpe");
addOption(document.drop_list.lga,"Warri-North", "Warri-North");
addOption(document.drop_list.lga,"Warri-South", "Warri-South");
addOption(document.drop_list.lga,"Uvwie", "Uvwie");
addOption(document.drop_list.lga,"Udu", "Udu");
addOption(document.drop_list.lga,"Warri Central", "Warri Central");
addOption(document.drop_list.lga,"Ukwani", "Ukwani");
addOption(document.drop_list.lga,"Oshimili-North", "Oshimili-North");
addOption(document.drop_list.lga,"Patani", "Patani");
}

if(document.drop_list.State.value == 'Ebonyi')
{
addOption(document.drop_list.lga,"Afikpo-South", "Afikpo-South");
addOption(document.drop_list.lga,"Afikpo-North", "Afikpo-North");
addOption(document.drop_list.lga,"Onicha", "Onicha");
addOption(document.drop_list.lga,"Ohaozara", "Ohaozara");
addOption(document.drop_list.lga,"Abakaliki", "Abakaliki");
addOption(document.drop_list.lga,"Ishielu", "Ishielu");
addOption(document.drop_list.lga,"Ikwo", "Ikwo");
addOption(document.drop_list.lga,"Ezza", "Ezza");
addOption(document.drop_list.lga,"Ezza-South", "Ezza-South");
addOption(document.drop_list.lga,"Ohaukwu", "Ohaukwu");
addOption(document.drop_list.lga,"Ebonyi", "Ebonyi");
addOption(document.drop_list.lga,"Ivo", "Ivo");
}

if(document.drop_list.State.value == 'Edo')
{
addOption(document.drop_list.lga,"Esan North-East", "Esan North-East");
addOption(document.drop_list.lga,"Esan South-East", "Esan South-East");
addOption(document.drop_list.lga,"Esan Central", "Esan Central");
addOption(document.drop_list.lga,"Esan West", "Esan West");
addOption(document.drop_list.lga,"Egor", "Egor");
addOption(document.drop_list.lga,"Ukpoba", "Ukpoba");
addOption(document.drop_list.lga,"Central", "Central");
addOption(document.drop_list.lga,"Etsako Central", "Etsako Central");
addOption(document.drop_list.lga,"Etsako East", "Etsako East");
addOption(document.drop_list.lga,"Etsako West", "Etsako West");
addOption(document.drop_list.lga,"Igueben", "Igueben");
addOption(document.drop_list.lga,"Oredo", "Oredo");
addOption(document.drop_list.lga,"Ovia South-West", "Ovia South-West");
addOption(document.drop_list.lga,"Ovia South-East", "Ovia South-East");
addOption(document.drop_list.lga,"Orhionwon", "Orhionwon");
addOption(document.drop_list.lga,"Uhunmwonde", "Uhunmwonde");
}

if(document.drop_list.State.value == 'Ekiti')
{
addOption(document.drop_list.lga,"Ado", "Ado");
addOption(document.drop_list.lga,"Ekiti-East", "Ekiti-East");
addOption(document.drop_list.lga,"Ekiti-West", "Ekiti-West");
addOption(document.drop_list.lga,"Emure/Ise/Orun", "Emure/Ise/Orun");
addOption(document.drop_list.lga,"Ekiti South-West", "Ekiti South-West");
addOption(document.drop_list.lga,"Ikare", "Ikare");
addOption(document.drop_list.lga,"Irepodun", "Irepodun");
addOption(document.drop_list.lga,"Ijero", "Ijero");
addOption(document.drop_list.lga,"Ido/Osi", "Ido/Osi");
addOption(document.drop_list.lga,"Oye", "Oye");
addOption(document.drop_list.lga,"Ikole", "Ikole");
addOption(document.drop_list.lga,"Moba", "Moba");
addOption(document.drop_list.lga,"Gbonyin", "Gbonyin");
addOption(document.drop_list.lga,"Efon", "Efon");
addOption(document.drop_list.lga,"Ise/Orun", "Ise/Orun");
addOption(document.drop_list.lga,"Ilejemeje", "Ilejemeje");
}

if(document.drop_list.State.value == 'Enugu')
{
addOption(document.drop_list.lga,"Enugu South", "Enugu South");
addOption(document.drop_list.lga,"Igbo-Eze South", "Igbo-Eze South");
addOption(document.drop_list.lga,"Enugu North", "Enugu North");
addOption(document.drop_list.lga,"Nkanu", "Nkanu");
addOption(document.drop_list.lga,"Udi Agwu", "Udi Agwu");
addOption(document.drop_list.lga,"Oji-River", "Oji-River");
addOption(document.drop_list.lga,"Ezeagu", "Ezeagu");
addOption(document.drop_list.lga,"Igbo Eze-North", "Igbo Eze-North");
addOption(document.drop_list.lga,"Isi-Uzo", "Isi-Uzo");
addOption(document.drop_list.lga,"Nsukka", "Nsukka");
addOption(document.drop_list.lga,"Igbo-Ekiti", "Igbo-Ekiti");
addOption(document.drop_list.lga,"Uzo-Uwani", "Uzo-Uwani");
addOption(document.drop_list.lga,"Enugu East", "Enugu East");
addOption(document.drop_list.lga,"Aninri", "Aninri");
addOption(document.drop_list.lga,"Nkanu East", "Nkanu East");
addOption(document.drop_list.lga,"Udenu", "Udenu");
}

if(document.drop_list.State.value == 'Gombe')
{
addOption(document.drop_list.lga,"Akko", "Akko");
addOption(document.drop_list.lga,"Balanga", "Balanga");
addOption(document.drop_list.lga,"Billiri", "Billiri");
addOption(document.drop_list.lga,"Dukku", "Dukku");
addOption(document.drop_list.lga,"Kaltungo", "Kaltungo");
addOption(document.drop_list.lga,"Kwami", "Kwami");
addOption(document.drop_list.lga,"Shomgom", "Shomgom");
addOption(document.drop_list.lga,"Funakaye", "Funakaye");
addOption(document.drop_list.lga,"Gombe", "Gombe");
addOption(document.drop_list.lga,"Nafada/Bajoga", "Nafada/Bajoga");
addOption(document.drop_list.lga,"Yamaltu/Delta", "Yamaltu/Delta");
}

if(document.drop_list.State.value == 'Imo')
{
addOption(document.drop_list.lga,"Aboh-Mbaise", "Aboh-Mbaise");
addOption(document.drop_list.lga,"Ahiazu-Mbaise", "Ahiazu-Mbaise");
addOption(document.drop_list.lga,"Ehime-Mbano", "Ehime-Mbano");
addOption(document.drop_list.lga,"Ezinihitte", "Ezinihitte");
addOption(document.drop_list.lga,"Ideato-North", "Ideato-North");
addOption(document.drop_list.lga,"Ideato-South", "Ideato-South");
addOption(document.drop_list.lga,"Ihitte/Uboma", "Ihitte/Uboma");
addOption(document.drop_list.lga,"Ikeduru", "Ikeduru");
addOption(document.drop_list.lga,"Isiala Mbano", "Isiala Mbano");
addOption(document.drop_list.lga,"Isu", "Isu");
addOption(document.drop_list.lga,"Mbaitolli", "Mbaitolli");
addOption(document.drop_list.lga,"Ngor-Okpala", "Ngor-Okpala");
addOption(document.drop_list.lga,"Njaba", "Njaba");
addOption(document.drop_list.lga,"Nwangele", "Nwangele");
addOption(document.drop_list.lga,"Nkwerre", "Nkwerre");
addOption(document.drop_list.lga,"Obowo", "Obowo");
addOption(document.drop_list.lga,"Oguta", "Oguta");
addOption(document.drop_list.lga,"Ohaji/Egbema", "Ohaji/Egbema");
addOption(document.drop_list.lga,"Okigwe", "Okigwe");
addOption(document.drop_list.lga,"Orlu", "Orlu");
addOption(document.drop_list.lga,"Orsu", "Orsu");
addOption(document.drop_list.lga,"Oru East", "Oru East");
addOption(document.drop_list.lga,"Oru West", "Oru West");
addOption(document.drop_list.lga,"Owerri-Municipal", "Owerri-Municipal");
addOption(document.drop_list.lga,"Owerri-North", "Owerri-North");
addOption(document.drop_list.lga,"Owerri-West", "Owerri-West");
}

if(document.drop_list.State.value == 'Jigawa')
{
addOption(document.drop_list.lga,"Auyo", "Auyo");
addOption(document.drop_list.lga,"Babura", "Babura");
addOption(document.drop_list.lga,"Birni Kudu", "Birni Kudu");
addOption(document.drop_list.lga,"Birniwa", "Birniwa");
addOption(document.drop_list.lga,"Buji", "Buji");
addOption(document.drop_list.lga,"Dutse", "Dutse");
addOption(document.drop_list.lga,"Gagarawa", "Gagarawa");
addOption(document.drop_list.lga,"Garki", "Garki");
addOption(document.drop_list.lga,"Gumel", "Gumel");
addOption(document.drop_list.lga,"Guri", "Guri");
addOption(document.drop_list.lga,"Gwaram", "Gwaram");
addOption(document.drop_list.lga,"Gwiwa", "Gwiwa");
addOption(document.drop_list.lga,"Hadejia", "hadejia");
addOption(document.drop_list.lga,"Jahun", "Jahun");
addOption(document.drop_list.lga,"Kafin Hausa", "Nkwerre");
addOption(document.drop_list.lga,"Kaugama Kazaure", "Kaugama Kazaure");
addOption(document.drop_list.lga,"Kiri Kasamma", "Kiri Kasamma");
addOption(document.drop_list.lga,"Kiyawa", "Kiyawa");
addOption(document.drop_list.lga,"Maigatari", "Maigatari");
addOption(document.drop_list.lga,"Malam Madori", "Malam Madori");
addOption(document.drop_list.lga,"Miga", "Miga");
addOption(document.drop_list.lga,"Ringim", "Ringim");
addOption(document.drop_list.lga,"Roni", "Roni");
addOption(document.drop_list.lga,"Sule-Tankarkar", "Sule-Tankarkar");
addOption(document.drop_list.lga,"Taura", "Taura");
addOption(document.drop_list.lga,"Yankwashi", "Yankwashi");
}

if(document.drop_list.State.value == 'Kaduna')
{
addOption(document.drop_list.lga,"Birni-Gwari", "Birni-Gwari");
addOption(document.drop_list.lga,"Chikun", "Chikun");
addOption(document.drop_list.lga,"Giwa", "Giwa");
addOption(document.drop_list.lga,"Igabi", "Igabi");
addOption(document.drop_list.lga,"Ikara", "Ikara");
addOption(document.drop_list.lga,"Jaba", "Jaba");
addOption(document.drop_list.lga,"Jema&acute;a", "Jema'a");
addOption(document.drop_list.lga,"Kachia", "Kachia");
addOption(document.drop_list.lga,"Kaduna North", "Kaduna North");
addOption(document.drop_list.lga,"Kaduna South", "Kaduna South");
addOption(document.drop_list.lga,"Kagarko", "Kagarko");
addOption(document.drop_list.lga,"Kajuru", "Kajuru");
addOption(document.drop_list.lga,"Kaura", "Kaura");
addOption(document.drop_list.lga,"Kubau", "Kubau");
addOption(document.drop_list.lga,"Kudan", "Kudan");
addOption(document.drop_list.lga,"Lere", "Lere");
addOption(document.drop_list.lga,"Makarfi", "Makarfi");
addOption(document.drop_list.lga,"Sabon-Gari", "Sabon-Gari");
addOption(document.drop_list.lga,"Sanga", "Sanga");
addOption(document.drop_list.lga,"Soba", "Soba");
addOption(document.drop_list.lga,"Zango-Kataf", "Zango-Kataf");
addOption(document.drop_list.lga,"Zaria", "Zaria");
}

if(document.drop_list.State.value == 'Kano')
{
addOption(document.drop_list.lga,"Ajingi", "Ajingi");
addOption(document.drop_list.lga,"Albasu", "Albasu");
addOption(document.drop_list.lga,"Bagwai", "Bagwai");
addOption(document.drop_list.lga,"Bebeji", "Bebeji");
addOption(document.drop_list.lga,"Bichi", "Bichi");
addOption(document.drop_list.lga,"Bunkure", "Bunkure");
addOption(document.drop_list.lga,"Dala", "Dala");
addOption(document.drop_list.lga,"Dambatta", "Dambatta");
addOption(document.drop_list.lga,"Dawakin Kudu", "Dawakin Kudu");
addOption(document.drop_list.lga,"Dawakin Tofa", "Dawakin Tofa");
addOption(document.drop_list.lga,"Doguwa", "Doguwa");
addOption(document.drop_list.lga,"Fagge", "Fagge");
addOption(document.drop_list.lga,"Gabasawa", "Gabasawa");
addOption(document.drop_list.lga,"Garko", "Garko");
addOption(document.drop_list.lga,"Garum", "Garum");
addOption(document.drop_list.lga,"Mallam", "Mallam");
addOption(document.drop_list.lga,"Gaya", "Gaya");
addOption(document.drop_list.lga,"Gezawa", "Gezawa");
addOption(document.drop_list.lga,"Gwale", "Gwale");
addOption(document.drop_list.lga,"Gwarzo", "Gwarzo");
addOption(document.drop_list.lga,"Kabo", "Kabo");
addOption(document.drop_list.lga,"Kano Municipal", "Kano Municipal");
addOption(document.drop_list.lga,"Karaye", "Karaye");
addOption(document.drop_list.lga,"Kibiya", "Kibiya");
addOption(document.drop_list.lga,"Kiru", "Kiru");
addOption(document.drop_list.lga,"Kumbotso", "Kumbotso");
addOption(document.drop_list.lga,"Kunchi", "Kunchi");
addOption(document.drop_list.lga,"Kura", "Kura");
addOption(document.drop_list.lga,"Madobi", "Madobi");
addOption(document.drop_list.lga,"Makoda", "Makoda");
addOption(document.drop_list.lga,"Minjibir", "Minjibir");
addOption(document.drop_list.lga,"Nasarawa", "Nasarawa");
addOption(document.drop_list.lga,"Rano", "Rano");
addOption(document.drop_list.lga,"Rimin Gado", "Rimin Gado");
addOption(document.drop_list.lga,"Rogo", "Rogo");
addOption(document.drop_list.lga,"Shanono", "Shanono");
addOption(document.drop_list.lga,"Sumaila", "Sumaila");
addOption(document.drop_list.lga,"Takali", "Takali");
addOption(document.drop_list.lga,"Tarauni", "Tarauni");
addOption(document.drop_list.lga,"Tofa", "Tofa");
addOption(document.drop_list.lga,"Tsanyawa", "Tsanyawa");
addOption(document.drop_list.lga,"Tudun Wada", "Tudun Wada");
addOption(document.drop_list.lga,"Ungogo", "Ungogo");
addOption(document.drop_list.lga,"Warawa", "Warawa");
addOption(document.drop_list.lga,"Wudil", "Wudil");
}

if(document.drop_list.State.value == 'Katsina')
{
addOption(document.drop_list.lga,"Bakori", "Bakori");
addOption(document.drop_list.lga,"Batagarawa", "Batagarawa");
addOption(document.drop_list.lga,"Batsari", "Batsari");
addOption(document.drop_list.lga,"Baure", "Baure");
addOption(document.drop_list.lga,"Bindawa", "Bindawa");
addOption(document.drop_list.lga,"Charanchi", "Chranchi");
addOption(document.drop_list.lga,"Dandume", "Dandume");
addOption(document.drop_list.lga,"Danja", "Danja");
addOption(document.drop_list.lga,"Dan Musa", "Dan Musa");
addOption(document.drop_list.lga,"Daura", "Daura");
addOption(document.drop_list.lga,"Dutsi", "Dutsi");
addOption(document.drop_list.lga,"Dutsin-Ma", "Dutsin-Ma");
addOption(document.drop_list.lga,"Faskari", "Faskari");
addOption(document.drop_list.lga,"Funtua", "Funtua");
addOption(document.drop_list.lga,"Ingawa", "Ingawa");
addOption(document.drop_list.lga,"Jibia", "Jibia");
addOption(document.drop_list.lga,"Kafur", "Kafur");
addOption(document.drop_list.lga,"Kaita", "Kaita");
addOption(document.drop_list.lga,"Kankara", "Kankara");
addOption(document.drop_list.lga,"Kankia", "Kankia");
addOption(document.drop_list.lga,"Katsina", "Katsina");
addOption(document.drop_list.lga,"Kurfi", "Kurfi");
addOption(document.drop_list.lga,"Kusada", "Kusada");
addOption(document.drop_list.lga,"Mai'adua", "Mai'adua");
addOption(document.drop_list.lga,"Malumfashi", "Malumfashi");
addOption(document.drop_list.lga,"Mani", "Mani");
addOption(document.drop_list.lga,"Mashi", "Mashi");
addOption(document.drop_list.lga,"Matazuu", "Matazuu");
addOption(document.drop_list.lga,"Musawa", "Musawa");
addOption(document.drop_list.lga,"Makoda", "Makoda");
addOption(document.drop_list.lga,"Rimi", "Rimi");
addOption(document.drop_list.lga,"Sabuwa", "Sabuwa");
addOption(document.drop_list.lga,"Safana", "Safana");
addOption(document.drop_list.lga,"Sandamu", "Sandamu");
addOption(document.drop_list.lga,"Zango", "Zango");
}

if(document.drop_list.State.value == 'Kebbi')
{
addOption(document.drop_list.lga,"Aliero", "Aliero");
addOption(document.drop_list.lga,"Arewa", "Arewa");
addOption(document.drop_list.lga,"Argungu", "Argungu");
addOption(document.drop_list.lga,"Augie", "Augie");
addOption(document.drop_list.lga,"Bagudo", "Bagudo");
addOption(document.drop_list.lga,"Birnin Kebbi", "Birnin Kebbi");
addOption(document.drop_list.lga,"Bunza", "Bunza");
addOption(document.drop_list.lga,"Dandi", "Dandi");
addOption(document.drop_list.lga,"Fakai", "Fakai");
addOption(document.drop_list.lga,"Gwandu", "Gwandu");
addOption(document.drop_list.lga,"Jega", "Jega");
addOption(document.drop_list.lga,"Kalgo", "Kalgo");
addOption(document.drop_list.lga,"Koko/Besse", "Koko/Besse");
addOption(document.drop_list.lga,"Maiyama", "Maiyama");
addOption(document.drop_list.lga,"Ngaski", "Ngaski");
addOption(document.drop_list.lga,"Sakaba", "Sakaba");
addOption(document.drop_list.lga,"Shanga", "Shanga");
addOption(document.drop_list.lga,"Suru", "Suru");
addOption(document.drop_list.lga,"Wasagu/Danko", "Wasgau/Danko");
addOption(document.drop_list.lga,"Yauri", "Yauri");
addOption(document.drop_list.lga,"Zuru", "Zuru");
}

if(document.drop_list.State.value == 'Kogi')
{
addOption(document.drop_list.lga,"Adavi", "Adavi");
addOption(document.drop_list.lga,"Ajaokuta", "Ajaokuta");
addOption(document.drop_list.lga,"Ankpa", "Ankpa");
addOption(document.drop_list.lga,"Bassa", "Bassa");
addOption(document.drop_list.lga,"Dekina", "Dekina");
addOption(document.drop_list.lga,"Ibaji", "Ibaji");
addOption(document.drop_list.lga,"Idah", "Idah");
addOption(document.drop_list.lga,"Igalamela-Odolu", "Igalamela-Odolu");
addOption(document.drop_list.lga,"Ijumu", "Ijumu");
addOption(document.drop_list.lga,"Kabba/Bunu", "Kabba/Bunu");
addOption(document.drop_list.lga,"Kogi", "Kogi");
addOption(document.drop_list.lga,"Lokoja", "Lokoja");
addOption(document.drop_list.lga,"Mopa-Muro", "Mopa-Muro");
addOption(document.drop_list.lga,"Ofu", "Ofu");
addOption(document.drop_list.lga,"Ogori/Mangongo", "Ogori/Mangongo");
addOption(document.drop_list.lga,"Okehi", "Okehi");
addOption(document.drop_list.lga,"Okene", "Okene");
addOption(document.drop_list.lga,"Olamabolo", "Olamabolo");
addOption(document.drop_list.lga,"Omala", "Omala");
addOption(document.drop_list.lga,"Yagba East", "Yagba East");
addOption(document.drop_list.lga,"Yagba West", "Yagba West");
}

if(document.drop_list.State.value == 'Kwara')
{
addOption(document.drop_list.lga,"Asa", "Asa");
addOption(document.drop_list.lga,"Baruten", "Baruten");
addOption(document.drop_list.lga,"Edu", "Edu");
addOption(document.drop_list.lga,"Ekiti", "Ekiti");
addOption(document.drop_list.lga,"Ifelodun", "Ifelodun");
addOption(document.drop_list.lga,"Ilorin East", "Ilorin East");
addOption(document.drop_list.lga,"Ilorin West", "Ilorin West");
addOption(document.drop_list.lga,"Ilorin South", "Ilorin South");
addOption(document.drop_list.lga,"Irepodun", "Irepodun");
addOption(document.drop_list.lga,"Isin", "Isin");
addOption(document.drop_list.lga,"Kaiama", "Kaiama");
addOption(document.drop_list.lga,"Moro", "Moro");
addOption(document.drop_list.lga,"Offa", "Offa");
addOption(document.drop_list.lga,"Oke-Ero", "Oke-Ero");
addOption(document.drop_list.lga,"Oyun", "Oyun");
addOption(document.drop_list.lga,"Pategi", "Pategi");
}

if(document.drop_list.State.value == 'Lagos')
{
addOption(document.drop_list.lga,"Agege", "Agege");
addOption(document.drop_list.lga,"Ajeromi-Ifelodun", "Ajeromi-Ifelodun");
addOption(document.drop_list.lga,"Alimosho", "Alimosho");
addOption(document.drop_list.lga,"Amuwo-Odofin", "Amuwo-Odofin");
addOption(document.drop_list.lga,"Apapa", "Apapa");
addOption(document.drop_list.lga,"Badagry", "Badagry");
addOption(document.drop_list.lga,"Epe", "Epe");
addOption(document.drop_list.lga,"Eti-Osa", "Eti-Osa");
addOption(document.drop_list.lga,"Ibeju/Lekki", "Ibeju/Lekki");
addOption(document.drop_list.lga,"Ifako-Ijaye", "Ifako-Ijaye");
addOption(document.drop_list.lga,"Ikeja", "Ikeja");
addOption(document.drop_list.lga,"Ikorodu", "Ikorodu");
addOption(document.drop_list.lga,"Kosofe", "Kosofe");
addOption(document.drop_list.lga,"Lagos Island", "Lagos Island");
addOption(document.drop_list.lga,"Lagos Mainland", "Lagos Mainland");
addOption(document.drop_list.lga,"Mushin", "Mushin");
addOption(document.drop_list.lga,"Ojo", "Ojo");
addOption(document.drop_list.lga,"Oshodi-Isolo", "Oshodi-Isolo");
addOption(document.drop_list.lga,"Shomolu", "Shomolu");
addOption(document.drop_list.lga,"Surulere", "Surulere");
}

if(document.drop_list.State.value == 'Nassarawa')
{
addOption(document.drop_list.lga,"Akwanga", "Akwanga");
addOption(document.drop_list.lga,"Awe", "Awe");
addOption(document.drop_list.lga,"Doma", "Doma");
addOption(document.drop_list.lga,"Karu", "Karu");
addOption(document.drop_list.lga,"Keana", "Keana");
addOption(document.drop_list.lga,"Keffi", "Keffi");
addOption(document.drop_list.lga,"Kokona", "Kokona");
addOption(document.drop_list.lga,"Lafia", "Lafia");
addOption(document.drop_list.lga,"Nassarawa", "Nassarawa");
addOption(document.drop_list.lga,"Nassarawa-Eggon", "Nassarawa-Eggon");
addOption(document.drop_list.lga,"Obi", "Obi");
addOption(document.drop_list.lga,"Toto", "Toto");
addOption(document.drop_list.lga,"Wamba", "Wamba");
}

if(document.drop_list.State.value == 'Niger')
{
addOption(document.drop_list.lga,"Agaie", "Agaie");
addOption(document.drop_list.lga,"Agwara", "Agwara");
addOption(document.drop_list.lga,"Bida", "Bida");
addOption(document.drop_list.lga,"Borgu", "Borgu");
addOption(document.drop_list.lga,"Bosso", "Bosso");
addOption(document.drop_list.lga,"Chanchaga", "Chanchaga");
addOption(document.drop_list.lga,"Edati", "Edati");
addOption(document.drop_list.lga,"Gbako", "Gbako");
addOption(document.drop_list.lga,"Gurara", "Gurara");
addOption(document.drop_list.lga,"Katcha", "Katcha");
addOption(document.drop_list.lga,"Kontagora", "Kontagora");
addOption(document.drop_list.lga,"Lapai", "Lapai");
addOption(document.drop_list.lga,"Lavun", "Lavun");
addOption(document.drop_list.lga,"Magama", "Magama");
addOption(document.drop_list.lga,"Mariga", "Mariga");
addOption(document.drop_list.lga,"Mashegu", "Mashegu");
addOption(document.drop_list.lga,"Mokwa", "Mokwa");
addOption(document.drop_list.lga,"Muya", "Muya");
addOption(document.drop_list.lga,"Pailoro", "Pailoro");
addOption(document.drop_list.lga,"Rafi", "Rafi");
addOption(document.drop_list.lga,"Rijau", "Rijau");
addOption(document.drop_list.lga,"Shiroro", "Shiroro");
addOption(document.drop_list.lga,"Suleja", "Suleja");
addOption(document.drop_list.lga,"Tafa", "Tafa");
addOption(document.drop_list.lga,"Wushishi", "Wushishi");
}

if(document.drop_list.State.value == 'Ogun')
{
addOption(document.drop_list.lga,"Abeokuta-North", "Abeokuta-North");
addOption(document.drop_list.lga,"Abeokuta-South", "Abeokuta-South");
addOption(document.drop_list.lga,"Ado-Odo/Ota", "Ado-Odo/Ota");
addOption(document.drop_list.lga,"Egbado-North", "Egbado-North");
addOption(document.drop_list.lga,"Egbado-South", "Egbado-South");
addOption(document.drop_list.lga,"Ewekoro", "Ewekoro");
addOption(document.drop_list.lga,"Ifo", "Ifo");
addOption(document.drop_list.lga,"Ijebu-East", "Ijebu-East");
addOption(document.drop_list.lga,"Ijebu-North", "Ijebu-North");
addOption(document.drop_list.lga,"Ijebu North-East", "Ijebu North-East");
addOption(document.drop_list.lga,"Ijebu Ode", "Ijebu Ode");
addOption(document.drop_list.lga,"Ikenne", "Ikenne");
addOption(document.drop_list.lga,"Imeko-Afon", "Imeko-Afon");
addOption(document.drop_list.lga,"Ipokia", "Ipokia");
addOption(document.drop_list.lga,"Obafemi-Owode", "Obafemi-Owode");
addOption(document.drop_list.lga,"Ogun Waterside", "Ogun Waterside");
addOption(document.drop_list.lga,"Odeda", "Odeda");
addOption(document.drop_list.lga,"Odogbolu", "Odogbolu");
addOption(document.drop_list.lga,"Remo North", "Remo North");
addOption(document.drop_list.lga,"Shagamu", "Shagamu");
}

if(document.drop_list.State.value == 'Ondo')
{
addOption(document.drop_list.lga,"Akoko North East", "Akoko North East");
addOption(document.drop_list.lga,"Akoko North West", "Akoko North West");
addOption(document.drop_list.lga,"Akoko South East", "Akoko South East");
addOption(document.drop_list.lga,"Akoko South West", "Akoko South West");
addOption(document.drop_list.lga,"Akure North", "Akure North");
addOption(document.drop_list.lga,"Akure South", "Akure South");
addOption(document.drop_list.lga,"Ese-Odo", "Ese-Odo");
addOption(document.drop_list.lga,"Idanre", "Idanre");
addOption(document.drop_list.lga,"Ifedore", "Ifedore");
addOption(document.drop_list.lga,"Ilaje", "Ilaje");
addOption(document.drop_list.lga,"Ile-Oluji", "Ile-Oluji");
addOption(document.drop_list.lga,"Okeigbo", "Okeigbo");
addOption(document.drop_list.lga,"Irele", "Irele");
addOption(document.drop_list.lga,"Odigbo", "Odigbo");
addOption(document.drop_list.lga,"Okitipupa", "Okitipupa");
addOption(document.drop_list.lga,"Ondo East", "Ondo East");
addOption(document.drop_list.lga,"Ondo West", "Ondo West");
addOption(document.drop_list.lga,"Ose", "Ose");
addOption(document.drop_list.lga,"Owo", "Owo");
}

if(document.drop_list.State.value == 'Osun')
{
addOption(document.drop_list.lga,"Aiyedade", "Aiyedade");
addOption(document.drop_list.lga,"Aiyedire", "Aiyedire");
addOption(document.drop_list.lga,"Atakumosa East", "Atakumosa East");
addOption(document.drop_list.lga,"Atakumosa West", "Atakumosa West");
addOption(document.drop_list.lga,"Boluwaduro", "Boluwaduro");
addOption(document.drop_list.lga,"Boripe", "Boripe");
addOption(document.drop_list.lga,"Ede North", "Ede North");
addOption(document.drop_list.lga,"Ede South", "Ede South");
addOption(document.drop_list.lga,"Egbedore", "Egbedore");
addOption(document.drop_list.lga,"Ejigbo", "Ejigbo");
addOption(document.drop_list.lga,"Ife Central", "Ife Central");
addOption(document.drop_list.lga,"Ife East", "Ife East");
addOption(document.drop_list.lga,"Ife North", "Ife North");
addOption(document.drop_list.lga,"Ife South", "Ife South");
addOption(document.drop_list.lga,"Ifedayo", "Ifedayo");
addOption(document.drop_list.lga,"Ifelodun", "Ifelodun");
addOption(document.drop_list.lga,"Ila", "Ila");
addOption(document.drop_list.lga,"Ilesha East", "Ilesha East");
addOption(document.drop_list.lga,"Ilesha West", "Ilesha West");
addOption(document.drop_list.lga,"Irepodun", "Irepodun");
addOption(document.drop_list.lga,"Irewole", "Irewole");
addOption(document.drop_list.lga,"Isokan", "Isokan");
addOption(document.drop_list.lga,"Iwo", "Iwo");
addOption(document.drop_list.lga,"Obokun", "Obokun");
addOption(document.drop_list.lga,"Odo-Otin", "Odo-Otin");
addOption(document.drop_list.lga,"Ola-Oluwa", "Ola-Oluwa");
addOption(document.drop_list.lga,"Olorunda", "Olorunda");
addOption(document.drop_list.lga,"Oriade", "Oriade");
addOption(document.drop_list.lga,"Orolu", "Orolu");
addOption(document.drop_list.lga,"Osogbo", "Osogbo");
}

if(document.drop_list.State.value == 'Oyo')
{
addOption(document.drop_list.lga,"Afijio", "Afijio");
addOption(document.drop_list.lga,"Akinyele", "Akinyele");
addOption(document.drop_list.lga,"Atiba", "Atiba");
addOption(document.drop_list.lga,"Atigbo", "Atigbo");
addOption(document.drop_list.lga,"Egbeda", "Egbeda");
addOption(document.drop_list.lga,"Ibadan Central", "Ibadan Central");
addOption(document.drop_list.lga,"Ibadan North", "Ibadan North");
addOption(document.drop_list.lga,"Ibadan North West", "Ibadan North West");
addOption(document.drop_list.lga,"Ibadan South East", "Ibadan South East");
addOption(document.drop_list.lga,"Ibadan South West", "Ibadan South West");
addOption(document.drop_list.lga,"Ibarapa East", "Ibarapa East");
addOption(document.drop_list.lga,"Ibarapa North", "Ibarapa North");
addOption(document.drop_list.lga,"Ido", "Ido");
addOption(document.drop_list.lga,"Irepo", "Irepo");
addOption(document.drop_list.lga,"Iseyin", "Iseyin");
addOption(document.drop_list.lga,"Itesiwaju", "Itesiwaju");
addOption(document.drop_list.lga,"Iwajowa", "Iwajowa");
addOption(document.drop_list.lga,"Kajola", "Kajola");
addOption(document.drop_list.lga,"Lagelu Ogbomosho North", "Lagelu Ogbomosho North");
addOption(document.drop_list.lga,"Ogbomosho South", "Ogbomosho South");
addOption(document.drop_list.lga,"Ogo Oluwa", "Ogo Oluwa");
addOption(document.drop_list.lga,"Olorunsogo", "Olorunsogo");
addOption(document.drop_list.lga,"Oluyole", "Oluyole");
addOption(document.drop_list.lga,"Ona-Ara", "Ona-Ara");
addOption(document.drop_list.lga,"Orelope", "Orelope");
addOption(document.drop_list.lga,"Ori Ire", "Ori Ire");
addOption(document.drop_list.lga,"Oyo East", "Oyo East");
addOption(document.drop_list.lga,"Oyo West", "Oyo West");
addOption(document.drop_list.lga,"Saki East", "Saki East");
addOption(document.drop_list.lga,"Saki West", "Saki West");
addOption(document.drop_list.lga,"Surulere", "Surulere");
}

if(document.drop_list.State.value == 'Plateau')
{
addOption(document.drop_list.lga,"Barikin Ladi", "Barikin Lado");
addOption(document.drop_list.lga,"Bassa", "Bassa");
addOption(document.drop_list.lga,"Bokkos", "Bokkos");
addOption(document.drop_list.lga,"Jos East", "Jos East");
addOption(document.drop_list.lga,"Jos North", "Jos North");
addOption(document.drop_list.lga,"Jos South", "Jos South");
addOption(document.drop_list.lga,"Kanam", "Kanam");
addOption(document.drop_list.lga,"Kanke", "Kanke");
addOption(document.drop_list.lga,"Langtang North", "Langtang North");
addOption(document.drop_list.lga,"Langtang South", "Langtang South");
addOption(document.drop_list.lga,"Mangu", "Mangu");
addOption(document.drop_list.lga,"Mikang", "Mikang");
addOption(document.drop_list.lga,"Pankshin", "Pankshin");
addOption(document.drop_list.lga,"Qua&acute;an Pan", "Qua'an Pan");
addOption(document.drop_list.lga,"Riyom", "Riyom");
addOption(document.drop_list.lga,"Shendam", "Shendam");
addOption(document.drop_list.lga, "Wase", "Wase");
}

if(document.drop_list.State.value == 'Rivers')
{
addOption(document.drop_list.lga,"Abua/Odual", "Abua/Odual");
addOption(document.drop_list.lga,"Ahoada East", "Ahoada East");
addOption(document.drop_list.lga,"Ahoada West", "Ahoada West");
addOption(document.drop_list.lga,"Akuku Toru", "Akuku Toru");
addOption(document.drop_list.lga,"Andoni", "Andoni");
addOption(document.drop_list.lga,"Asari-Toru", "Asari-Toru");
addOption(document.drop_list.lga,"Bonny", "Bonny");
addOption(document.drop_list.lga,"Degema", "Degema");
addOption(document.drop_list.lga,"Emohua", "Emohua");
addOption(document.drop_list.lga,"Eleme", "Eleme");
addOption(document.drop_list.lga,"Etche", "Etche");
addOption(document.drop_list.lga,"Gokana", "Gokana");
addOption(document.drop_list.lga,"Ikwerre", "Ikwerre");
addOption(document.drop_list.lga,"Khana", "Khana");
addOption(document.drop_list.lga,"Obia/Akpor", "Obia/Akpor");
addOption(document.drop_list.lga,"Ogba/Egbema/Ndoni", "Ogba/Egbema/Ndoni");
addOption(document.drop_list.lga,"Ogu/Bolo", "Ogu/Bolo");
addOption(document.drop_list.lga,"Okrika", "Okrika");
addOption(document.drop_list.lga,"Omumma", "Omumma");
addOption(document.drop_list.lga,"Opobo/Nkoro", "Opobo/Nkoro");
addOption(document.drop_list.lga,"Oyigbo", "Oyigbo");
addOption(document.drop_list.lga,"Port-Harcourt", "Port-Harcourt");
addOption(document.drop_list.lga,"Tai", "Tai");
}

if(document.drop_list.State.value == 'Sokoto')
{
addOption(document.drop_list.lga,"Binji", "Binji");
addOption(document.drop_list.lga,"Bodinga", "Bodinga");
addOption(document.drop_list.lga,"Dange-Shuni", "Dange-Shuni");
addOption(document.drop_list.lga,"Gada", "Gada");
addOption(document.drop_list.lga,"Goronyo", "Goronyo");
addOption(document.drop_list.lga,"Gudu", "Gudu");
addOption(document.drop_list.lga,"Gwadabawa", "Gwadabawa");
addOption(document.drop_list.lga,"Illela", "Illela");
addOption(document.drop_list.lga,"Isa", "Isa");
addOption(document.drop_list.lga,"Kware", "Kware");
addOption(document.drop_list.lga,"Kebbe", "Kebbe");
addOption(document.drop_list.lga,"Rabah", "Rabah");
addOption(document.drop_list.lga,"Sabon Birni", "Sabon Birni");
addOption(document.drop_list.lga,"Shagari", "Shagari");
addOption(document.drop_list.lga,"Silame", "Silame");
addOption(document.drop_list.lga,"Sokoto North", "Sokoto North");
addOption(document.drop_list.lga,"Sokoto South", "Sokoto South");
addOption(document.drop_list.lga,"Tambuwal", "Tambuwal");
addOption(document.drop_list.lga,"Tangaza", "Tangaza");
addOption(document.drop_list.lga,"Tureta", "Tureta");
addOption(document.drop_list.lga,"Wamako", "Wamako");
addOption(document.drop_list.lga,"Wurno", "Wurno");
addOption(document.drop_list.lga,"Yabo", "Yabo");
}

if(document.drop_list.State.value == 'Taraba')
{
addOption(document.drop_list.lga,"Ardo-Kola", "Ardo-Kola");
addOption(document.drop_list.lga,"Bali", "Bali");
addOption(document.drop_list.lga,"Donga", "Donga");
addOption(document.drop_list.lga,"Gashaka", "Gashaka");
addOption(document.drop_list.lga,"Cassol", "Cassol");
addOption(document.drop_list.lga,"Ibi", "Ibi");
addOption(document.drop_list.lga,"Jalingo", "Jalingo");
addOption(document.drop_list.lga,"Karin-Lamido", "Karin-Lamido");
addOption(document.drop_list.lga,"Kurmi", "Kurmi");
addOption(document.drop_list.lga,"Lau", "Lau");
addOption(document.drop_list.lga,"Sardauna", "Sardauna");
addOption(document.drop_list.lga,"Takum", "Takum");
addOption(document.drop_list.lga,"Ussa", "Ussa");
addOption(document.drop_list.lga,"Wukari", "Wukari");
addOption(document.drop_list.lga,"Yorro", "Yorro");
addOption(document.drop_list.lga,"Zing", "Zing");
}

if(document.drop_list.State.value == 'Yobe')
{
addOption(document.drop_list.lga,"Bade", "Bade");
addOption(document.drop_list.lga,"Bursai", "Bursai");
addOption(document.drop_list.lga,"Damaturu", "Damaturu");
addOption(document.drop_list.lga,"Fika", "Fika");
addOption(document.drop_list.lga,"Fune", "Fune");
addOption(document.drop_list.lga,"Geidam", "Geidam");
addOption(document.drop_list.lga,"Gujba", "Gujba");
addOption(document.drop_list.lga,"Gulani", "Gulani");
addOption(document.drop_list.lga,"Jakusko", "Jakusko");
addOption(document.drop_list.lga,"Kasaruwa", "Kasaruwa");
addOption(document.drop_list.lga,"Karawa", "Karawa");
addOption(document.drop_list.lga,"Machina", "Machina");
addOption(document.drop_list.lga,"Nangere", "Nangere");
addOption(document.drop_list.lga,"Nguru Potiskum", "Nguru Potiskum");
addOption(document.drop_list.lga,"Tarmua", "Tarmua");
addOption(document.drop_list.lga,"Yunusari", "Yunusari");
addOption(document.drop_list.lga,"Yusufari", "Yusufari");
}

if(document.drop_list.State.value == 'Zamfara')
{
addOption(document.drop_list.lga,"Anka", "Anka");
addOption(document.drop_list.lga,"Bakura", "Bakura");
addOption(document.drop_list.lga,"Birnin Magaji", "Birnin Magaji");
addOption(document.drop_list.lga,"Bukkuyum", "Bukkuyum");
addOption(document.drop_list.lga,"Bungudu", "Bungudu");
addOption(document.drop_list.lga,"Gummi", "Gummi");
addOption(document.drop_list.lga,"Gusau", "Gusua");
addOption(document.drop_list.lga,"Kaura", "Kaura");
addOption(document.drop_list.lga,"Namoda", "Namoda");
addOption(document.drop_list.lga,"Maradun", "Maradun");
addOption(document.drop_list.lga,"Maru", "Maru");
addOption(document.drop_list.lga,"Shinkafi", "Shinkafi");
addOption(document.drop_list.lga,"Talata Mafara", "Talata Mafara");
addOption(document.drop_list.lga,"Tsafe", "Tsafe");
addOption(document.drop_list.lga,"Zurmi", "Zurmi");
}

if(document.drop_list.State.value == 'Others')
{
addOption(document.drop_list.lga,"Not Specified", "Not Specified");
}

}


////////////////// 

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


function addOption(selectbox, value, text )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;

	selectbox.options.add(optn);
}

