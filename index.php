<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt - bd</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Projekt Końcowy</h1>
        <nav>
            <a href="#1">Testowanie Zapytania</a>
            <a href="#2">Implementacja</a>
            <a href="#4"><b>Widoki</b></a>
        </nav>
    </header>
    <section id="1">
        <h1>Testowanie Zapytania</h1>
        <p>1. Wyświetla dane piłkarzy oraz klub, do którego należą:</p>
        <code>select Zawodnicy.Imie, Zawodnicy.Nazwisko, Kluby.Nazwa from Zawodnicy left join Kluby on Kluby.Id = Zawodnicy.Klub_Id</code>
        <p>2. Wyświetla wynik, nazwę klubu, numer kolejki sortując od najmłodszej daty założenia klubu:</p>
        <code>select Faza_Ligowa.Wynik, Kluby.Nazwa, Faza_Ligowa.Kolejka from Kluby <br>left join Faza_Ligowa on Kluby.Id = Faza_Ligowa.Zwyciezca_Id order by Kluby.Data_Zalozenia DESC;</code>
        <p>3. Wyświetla ilość wygranych meczy oraz nazwę klubu:</p>
        <code>select COUNT(Faza_Ligowa.Zwyciezca_Id), Kluby.Nazwa from Kluby left join Faza_Ligowa on Faza_Ligowa.Zwyciezca_Id = Kluby.Id group by Kluby.Nazwa;</code>
        <p>4. Wyświetla ilość wygranych meczy klubu dla każdego trenera:</p>
        <code>select trenerzy.Imie, trenerzy.Nazwisko, count(faza_ligowa.Zwyciezca_Id) from trenerzy <br> right JOIN faza_ligowa on faza_ligowa.Zwyciezca_Id = trenerzy.Klub_Id group BY trenerzy.Imie; </code>
        <p>5. Wyświetla nazwę klubów, wynik tych, którzy mieli remis:</p>
        <code>select k1.Nazwa, k2.Nazwa, faza_ligowa.Wynik from remisy left join kluby as k1 on k1.Id = remisy.Klub_Id_1 <br> left join kluby as k2 on k2.Id = remisy.Klub_Id_2 join faza_ligowa on faza_ligowa.Id = remisy.Kolejka_Id;</code>
    </section>
    <section id="2">
        <h1>Implementacja</h1>
        <p>Relacje między tabelami</p>
        <table>
            <tr>
                <th>Połączenie</th>
                <th>Relacja</th>
                <th>Uzasadnienie</th>
            </tr>
            <tr>
                <td>Kluby (Id) - Faza_Ligowa (Zwyciezca_Id, Przegrany_Id)</td>
                <td>1:W</td>
                <td>Jeden klub gra w wielu kolejkach</td>
            </tr>
            <tr>
                <td>Kluby (Id) - Trenerzy (Klub_Id)</td>
                <td>1:1</td>
                <td>Jeden trener jest trenerem jednego klubu</td>
            </tr>
            <tr>
                <td>Kluby (Id) - Zawodnicy (Klub_Id)</td>
                <td>1:W</td>
                <td>Jeden klub ma wielu piłkarzy</td>
            </tr>
            <tr>
                <td>Faza_Ligowa (Id) - Remisy (Klub_1_Id, Klub_2_Id)</td>
                <td>1:W</td>
                <td>Jeden klub może mieć wiele remisów</td>
        </table>
        <img id="bi" src="diagram_ka.jpg">
        <img src="projekt20.drawio.png">
    </section>
    <section id="4">
        <code>CREATE VIEW k_t as SELECT kluby.Nazwa, trenerzy.Imie, trenerzy.Nazwisko from kluby left join trenerzy on trenerzy.Klub_Id = kluby.Id </code>
        <?php $db = new mysqli("localhost:84", "root", "", "liga_mistrzow");

$result = $db->query("SELECT * FROM k_t");

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Nazwa klubu</th>
            <th>Imię Trenera</th>
            <th>Nazwisko Trenera</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Nazwa']}</td>
                <td>{$row['Imie']}</td>
                <td>{$row['Nazwisko']}</td>
              </tr>";
    }
    echo "</table>";
}
$db->close();
?>
        <code>CREATE VIEW Z_K AS SELECT zawodnicy.Imie, zawodnicy.Nazwisko, kluby.Nazwa FROM zawodnicy LEFT JOIN Kluby ON zawodnicy.Id = kluby.Id</code>
        <?php $db = new mysqli("localhost:84", "root", "", "liga_mistrzow");

$result = $db->query("SELECT * FROM z_k");

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Imię Piłkarza</th>
            <th>Nazwisko Piłkarza</th>
            <th>Nazwa Klubu</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Imie']}</td>
                <td>{$row['Nazwisko']}</td>
                <td>{$row['Nazwa']}</td>
              </tr>";
    }
    echo "</table>";
}
$db->close();
?>
        <code>SHOW FULL TABLES WHERE TABLE_TYPE = 'VIEW';</code>
        <?php $db = new mysqli("localhost:84", "root", "", "liga_mistrzow");

$result = $db->query("SHOW FULL TABLES WHERE TABLE_TYPE = 'VIEW';");

if ($result->num_rows > 0) {
    echo "<table>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Tables_in_liga_mistrzow']}</td>
                <td>{$row['Table_type']}</td>
              </tr>";
    }
    echo "</table>";
}
$db->close();
?>


</body>
</html>
