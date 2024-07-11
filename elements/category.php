<section class="section-category">
    <h4>Dostępne kategorie</h4>
    <div>
        <?php
            $sqlQuery = "SELECT category.id, category.title, category.image FROM category";
            $queryResult = $connection->query($sqlQuery);
            foreach($queryResult as $row) {
                echo <<<CATEGORY
                    <a href='../category.php?c={$row['id']}' class='category-box' style='background-image: url("../image/category/{$row['image']}")'>
                        <p>{$row['title']}</p>
                    </a>
                CATEGORY;
            }
        ?>
    </div>
</section>