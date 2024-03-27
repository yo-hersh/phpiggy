<?php include $this->resolve('partials/_header.php'); ?>

<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <?php
    $errors = $flash['errors'] ?? [];
    $oldFormData = $flash['oldFormData'] ?? [];
    ?>
    <form method="POST" class="grid grid-cols-1 gap-6">
        <?php include $this->resolve("partials/_csrf.php"); ?>

        <label class="block">
            <span class="text-gray-700">Description</span>
            <input name="description" value="<?php echo formDataPrinting($oldFormData, 'description', $errors) ?>" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            <?php formErrorPrinting('description', $errors) ?>
        </label>
        <label class="block">
            <span class="text-gray-700">Amount</span>
            <input name="amount" value="<?php echo formDataPrinting($oldFormData, 'amount', $errors) ?>" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            <?php formErrorPrinting('amount', $errors) ?>
        </label>
        <label class="block">
            <span class="text-gray-700">Date</span>
            <input name="date" value="<?php echo formDataPrinting($oldFormData, 'date', $errors) ?>" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            <?php formErrorPrinting('date', $errors) ?>
        </label>

        <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
            Submit
        </button>
    </form>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>