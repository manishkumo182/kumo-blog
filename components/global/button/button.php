<?php
$button_type = array_key_exists('button_type', $button_styles) ? $button_styles['button_type'] : 'primary';
$component_type = array_key_exists('component_type', $button_styles) ? $button_styles['component_type'] : 'link';
$button_class = array_key_exists('class', $button_styles) ? $button_styles['class'] : '';
$size = array_key_exists('size', $button_styles) ? $button_styles['size'] : 'lg';
$attr = array_key_exists('attr', $button_styles) ? $button_styles['attr'] : '';
$colour = array_key_exists('colour', $button_styles) ? $button_styles['colour'] : 'stone';
$text = array_key_exists('text', $button) ? $button['text'] : '';
$type = array_key_exists('type', $button) ? $button['type'] : 'internal';
$url = array_key_exists('url', $button) ? $button['url'] : '#';
$links_to = array_key_exists('links_to', $button) ? get_permalink($button['links_to']) : '';
$link = $type == 'internal' ? $links_to : $url;
$icon = array_key_exists('icon', $button_styles) ? $button_styles['icon'] : '';

$className = [
  $button_type == 'primary' ? 'bg-primary hover:bg-primary-600 hover:text-white text-white max-w-60' : '',
  $button_type == 'secondary' ? 'bg-color hover:bg-secondary-600 hover:text-black  max-w-60' : '',
  $button_type == 'outline' ? 'bg-transparent border' : '',
  $button_type == 'outline' && $colour == 'stone' ? 'hover:bg-lightstone hover:text-white text-stone  border-stone max-w-40' : '',
  $button_type == 'outline' && $colour == 'white' ? 'hover:bg-stone-100 hover:text-stone-900 text-white  border-white max-w-40' : '',
  $button_type == 'text' && $colour == 'white' ? 'bg-white hover:bg-lightstone-100 hover:text-stone text-white border-stone max-w-40' : '',
  $button_type == 'text' && $colour == 'white' ? 'bg-white hover:bg-lightstone-100 hover:text-white text-white border-white max-w-40' : '',
  $size == 'lg' ? 'py-3 px-6 m-2' : '',
  $size == 'sm' ? 'py-2 px-5' : '',
  $button_type == 'primary' ? 'font-xl' : '',
  $button_type == 'outline' ? 'font-medium' : '',
  $button_type == 'text' ? 'font-xl' : '',
  'transition duration-300 ease-out flex justify-center font-lg rounded-full',
  $button_class,
];
$classString = implode(' ', array_filter($className));
?>
<?php if ($component_type == 'button'): ?>
  <button type="button" class="<?= $classString ?>"><?= $text ?>   <?= get_svg($icon); ?></button>
<?php else: ?>
  <a href="<?= $link ?>" <?php if ($type == 'external'): ?> target="_blank" <?php endif; ?>
    class="<?= $classString ?>"><?= $text ?>   <?= get_svg($icon); ?></a>
<?php endif; ?>
<?php
unset($button);
unset($button_styles);
?>