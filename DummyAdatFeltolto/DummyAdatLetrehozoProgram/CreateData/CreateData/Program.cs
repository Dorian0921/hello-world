using System;
using System.IO;

using System.Text;
namespace CreateData
{
    class Program
    {




        static void Main(string[] args)
        {
            //Raw data beolvasása
            string[] melleknevek = File.ReadAllLines("melleknev.txt");
            string[] allatok = File.ReadAllLines("allatok.txt");
            string[] vezeteknevek = File.ReadAllLines("vezeteknevek.txt");
            string[] noinevek = File.ReadAllLines("noinevek.txt");
            string[] ferfinevek = File.ReadAllLines("ferfinevek.txt");
            string[] varosok = File.ReadAllLines("szekhelyek.txt");
            string[] foglalkozasok = File.ReadAllLines("foglalkozasok.txt");
            string[] jegykategoriak = File.ReadAllLines("jegykategoria.txt");
            string[] jegyar = File.ReadAllLines("jegyar.txt");
            int[] dolgozok_szama = new int[varosok.Length];

            //id-k amik később kellenek majd
            int beosztasid = 1;
            int eladottjegyid = 1;
            string password = "123456";

            int darab = 3000;//<--- Létrehozandó felhasználók száma min.2500-3000 hogy legyen elég dolgozónk max:23500 a jelenlegi melléknevekkel és állatnevekkel
            string[] usernames = new string[darab];



            //kész sql fájlok kiírása fájlba
            bool folderExists = Directory.Exists("sqlfiles");
            if (!folderExists)
            {
                Directory.CreateDirectory("sqlfiles");
            }
            StreamWriter login = new StreamWriter(@"sqlfiles\login.sql", append: false);
            StreamWriter utas = new StreamWriter(@"sqlfiles\utas.sql", append: false);
            StreamWriter dolgozo = new StreamWriter(@"sqlfiles\dolgozo.sql", append: false);
            StreamWriter varosiro = new StreamWriter(@"sqlfiles\varosok.sql", append: false);
            StreamWriter vonatok = new StreamWriter(@"sqlfiles\vonatok.sql", append: false);
            StreamWriter rendezveny = new StreamWriter(@"sqlfiles\rendezveny.sql", append: false);
            StreamWriter jegyiro = new StreamWriter(@"sqlfiles\jegy.sql", append: false);
            StreamWriter beosztas = new StreamWriter(@"sqlfiles\beosztas.sql", append: false);
            StreamWriter eladottjegyek = new StreamWriter(@"sqlfiles\eladottjegyek.sql", append: false);
            StreamWriter mozdonyvezeto = new StreamWriter(@"sqlfiles\mozdonyvezeto.xml",false,Encoding.UTF8);


            Random r = new Random();


            //itt feltöltöm ezt a 2 tömböt semmivel 
            for (int i = 0; i < dolgozok_szama.Length; i++)
            {
                dolgozok_szama[i] = 0;
            }
            for (int i = 0; i < darab; i++)
            {
                usernames[i] = "";
            }

            //Userek létrehozása
            for (int i = 0; i < darab; i++)
            {
                string username = melleknevek[r.Next(0, melleknevek.Length)] + "_" + allatok[r.Next(0, allatok.Length)];

                username = username.Replace('á', 'a');//lecserélem az ékezetes betűket mert ez ugye egy username
                username = username.Replace('é', 'e');
                username = username.Replace('í', 'i');
                username = username.Replace('ó', 'o');
                username = username.Replace('ö', 'o');
                username = username.Replace('ő', 'o');
                username = username.Replace('ú', 'u');
                username = username.Replace('ü', 'u');
                username = username.Replace('ű', 'u');


                for (int j = 0; j < usernames.Length; j++)
                {
                    if (usernames[j] == username)//<--- Így biztos nem lesz 2 egyforma felhasználónév
                    {
                        username = melleknevek[r.Next(0, melleknevek.Length)] + "_" + allatok[r.Next(0, allatok.Length)];

                        //ide meg csak be CTRL-C CTRL-V-ztem mert már késő van és biztos hogy nem fogok ezért egy függvényt írni hogy szép legyen
                        username = username.Replace('á', 'a');//lecserélem az ékezetes betűket mert ez ugye egy username
                        username = username.Replace('é', 'e');
                        username = username.Replace('í', 'i');
                        username = username.Replace('ó', 'o');
                        username = username.Replace('ö', 'o');
                        username = username.Replace('ő', 'o');
                        username = username.Replace('ú', 'u');
                        username = username.Replace('ü', 'u');
                        username = username.Replace('ű', 'u');

                        j = 0;
                    }

                }
                usernames[i] = username;

                string nev;

                if (r.Next(0, 10) % 2 == 0)//Nő
                {
                    nev = vezeteknevek[r.Next(0, vezeteknevek.Length)] + " " + noinevek[r.Next(0, noinevek.Length)];
                }
                else//Férfi
                {
                    nev = vezeteknevek[r.Next(0, vezeteknevek.Length)] + " " + ferfinevek[r.Next(0, ferfinevek.Length)];
                }
                int ev = r.Next(1940, 2008);
                string szuldatum = Convert.ToString(ev) + "-" + Convert.ToString(r.Next(1, 12)) + "-" + Convert.ToString(r.Next(1, 28));

                if (r.Next(0, 5) == 2)//20% esély hogy dolgozó lesz az adoot létrehozott felhasználó
                {
                    szuldatum = Convert.ToString(r.Next(1970, 2000)) + "-" + Convert.ToString(r.Next(1, 12)) + "-" + Convert.ToString(r.Next(1, 28));
                    string ber = Convert.ToString(r.Next(1450, 2350));
                    string foglalkozas = foglalkozasok[r.Next(0, foglalkozasok.Length)];
                    string varos = varosok[r.Next(0, varosok.Length)];
                    for (int j = 0; j < varosok.Length; j++)
                    {
                        if (varosok[j] == varos)
                        {
                            dolgozok_szama[j]++;
                        }
                    }
                    dolgozo.WriteLine("INSERT INTO DOLGOZOK(USERNAME,NEV,SZULDATUM,BER,FOGLALKOZAS,VAROS)VALUES('{0}','{1}',TO_DATE('{2}', 'yyyy/mm/dd'),'{3}','{4}','{5}');", username, nev, szuldatum, ber, foglalkozas, varos); //dolgozo.sql parancsai
                    
                    
                    //BEOSZTÁS
                    string mettol = "";
                    string meddig = "";

                    switch (r.Next(0, 6))//<--random kiválasztok egy munkaidőszakot a dolgozónak
                    {
                        case 0:
                            mettol = "1970-01-01 00:00:00";
                            meddig = "1970-01-04 08:00:00";
                            break;
                        case 1:
                            mettol = "1970-01-01 08:00:00";
                            meddig = "1970-01-04 16:00:00";
                            break;
                        case 2:
                            mettol = "1970-01-01 16:00:00";
                            meddig = "1970-01-04 23:59:59";
                            break;
                        case 3:
                            mettol = "1970-01-05 00:00:00";
                            meddig = "1970-01-07 08:00:00";
                            break;
                        case 4:
                            mettol = "1970-01-05 08:00:00";
                            meddig = "1970-01-07 16:00:00";
                            break;
                        case 5:
                            mettol = "1970-01-05 16:00:00";
                            meddig = "1970-01-07 23:59:59";
                            break;
                        default:
                            mettol = "1970-01-01 00:00:00";
                            meddig = "1970-01-04 08:00:00";
                            break;
                    }

                    beosztas.WriteLine("INSERT INTO BEOSZTAS(ID,USERNAME,METTOL,MEDDIG)VALUES('{0}','{1}',timestamp '{2}',timestamp '{3}');", beosztasid, username, mettol, meddig);//beosztas.sql parancsai
                    if (foglalkozas == "mozdonyvezető")
                    {
                        mozdonyvezeto.WriteLine("{0}\t{1}\t{2}\t{3}\t{4}\t{5}", username, nev, foglalkozas, varos, mettol, meddig);
                    }
                    beosztasid++;
                }
                else//UTAS
                {
                    string email = username;

                    switch (r.Next(0, 5))// különböző e-mail szolgáltatókat rendelek hozzá hogy életűbb legyen vagy mi idk.
                    {
                        case 0:
                            email += "@gmail.com";
                            break;
                        case 1:
                            email += "@yahoo.com";
                            break;
                        case 2:
                            email += "@gmail.hu";
                            break;
                        case 3:
                            email += "@citromail.hu";           //SUCH DIFFERENCE MUCH WOW!!4
                            break;
                        case 4:
                            email += "@freemail.hu";
                            break;

                        default:
                            email += "@gmail.com";
                            break;
                    }

                    string diak = "0";
                    string nyugdijas = "0";

                    //Eldöntjük hogy diák vagy nyugdíjas-e ha egyik sem akkor marad 0
                    if (2021 - ev < 18)
                    {
                        diak = "1";
                    }
                    else if (2021 - ev > 65)
                    {
                        nyugdijas = "1";
                    }
                    utas.WriteLine("INSERT INTO UTAS(USERNAME, NEV, SZULDATUM, EMAIL, DIAK, NYUGDIJAS)VALUES('{0}','{1}',TO_DATE('{2}', 'yyyy/mm/dd'),'{3}','{4}','{5}');", username, nev, szuldatum, email, diak, nyugdijas);//utas.sql parancsai

                    //ELADOTTJEGYEK

                    for (int j = 0; j < r.Next(2, 8); j++)//<---Vásárolt jegyek száma
                    {
                        int kat = r.Next(0, jegykategoriak.Length);
                        string vasarlasidopont = Convert.ToString(r.Next(2017, 2021)) + "-" + Convert.ToString(r.Next(1, 12)) + "-" + Convert.ToString(r.Next(1, 28));
                        string honnan = varosok[r.Next(0, varosok.Length)];
                        string hova = varosok[r.Next(0, varosok.Length)];
                        while (honnan == hova)
                        {
                            hova = varosok[r.Next(0, varosok.Length)];
                        }
                        int km = r.Next(2, 17);//ideiglenes km vagy súlyérték a városok között ameddig ki nem találjuk hogy az mi lesz
                        string ar = Convert.ToString(Convert.ToInt32(jegyar[kat]) * km);

                        eladottjegyek.WriteLine("INSERT INTO ELADOTTJEGYEK(ID,USERNAME,JEGYKATEGORIA,IDOPONT,HONNAN,HOVA,AR)VALUES('{0}','{1}','{2}',TO_DATE('{3}', 'yyyy/mm/dd'),'{4}','{5}','{6}');", eladottjegyid, username, jegykategoriak[kat], vasarlasidopont, honnan, hova, ar);//eladottjegyek.sql parancsai
                        eladottjegyid++;
                    }



                }



                login.WriteLine("INSERT INTO LOGIN(USERNAME, PASSWORD)VALUES('{0}', '{1}');", username, password);// login.sql (az összes username és password) parancsai
            }

            for (int i = 0; i < varosok.Length; i++)//VAROSOK
            {
                varosiro.WriteLine("INSERT INTO VAROSOK(VAROSNEV,DOLGOZOK_SZAMA)VALUES('{0}','{1}');", varosok[i], dolgozok_szama[i]);//varosok.sql parancsai
            }




            for (int i = 0; i < 50; i++) //VONATOK most éppen 50 vonat de lehet hogy kell több idk
            {
                string elso = Convert.ToString(r.Next(0, 3));
                string masod = Convert.ToString(r.Next(2, 6));
                string bicikli = "1";
                if (r.Next(0, 10) % 5 == 0)
                {
                    bicikli = "0";
                }
                string nev = melleknevek[r.Next(0, melleknevek.Length)] + "-" + allatok[r.Next(0, allatok.Length)];

                vonatok.WriteLine("INSERT INTO VONATOK(SZERELVENY_SZAM,ELSOOSZTALYU_KOCSIK_SZAMA,MASODOSZTALYU_KOCSIK_SZAMA,BICIKLI,NEV)VALUES('{0}','{1}','{2}','{3}','{4}');", i + 1, elso, masod, bicikli, nev); //vonatok.sql parancsai

            }


            for (int i = 0; i < 30; i++)//Szuper király rendezvények
            {
                string rendezvenynev = "Éves " + allatok[r.Next(0, allatok.Length)] + " ünnepély";
                string idopont = "2021-" + Convert.ToString(r.Next(0, 12)) + "-" + Convert.ToString(r.Next(0, 28));
                string helyszin = varosok[r.Next(0, varosok.Length)];

                rendezveny.WriteLine("INSERT INTO RENDEZVENY(RENDEZVENYNEV,IDOPONT,HELYSZIN)VALUE('{0}','{1}','{2}');", rendezvenynev, idopont, helyszin);//rendezvenyek.sql parancsai
            }



            for (int i = 0; i < jegykategoriak.Length; i++)//jegykategoria
            {
                jegyiro.WriteLine("INSERT INTO JEGY_AR(ID, KATEGORIA, AR_KM)VALUES('{0}','{1}','{2}');", i + 1, jegykategoriak[i], jegyar[i]);//jegy.sql parancsai
            }


            /*minden írót amit egyszer létrehozol és megnyitod azt le is kell zárni
            másképp vagy ír bele valamit vagy egyáltalán semmit
            de az boztos hogy nem lesz benne minden amit bele akartál rakni
            szóval mindig zárd le!!!*/
            mozdonyvezeto.Close();
            varosiro.Close();
            dolgozo.Close();
            utas.Close();
            login.Close();
            vonatok.Close();
            rendezveny.Close();
            jegyiro.Close();
            beosztas.Close();
            eladottjegyek.Close();
            Console.WriteLine("Done");
            Console.Beep(1200, 690);//Yeay happy everything worked noises
            Console.ReadLine();
        }
    }
}
