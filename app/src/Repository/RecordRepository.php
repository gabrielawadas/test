<?php
/**
 * Record repository.
 */

namespace App\Repository;

/**
 * Class RecordRepository.
 */
class RecordRepository
{
    /**
     * Data.
     *
     * @var array
     */
    private $data = [
        1 => [
            'id' => 1,
            'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin et hendrerit augue, non porta ligula. Etiam sodales, sapien sed pulvinar molestie, dolor dolor fringilla urna, ac tincidunt libero metus a lorem. Proin maximus est eu sapien euismod pellentesque. Sed gravida odio quis urna ultrices, tempus ultricies quam imperdiet. Nam malesuada eleifend molestie. Phasellus id ullamcorper risus. Duis et ultricies purus. Sed sed dictum nibh. Pellentesque dignissim auctor urna. Curabitur mattis tincidunt eleifend. Curabitur nec suscipit est.',
            'tags' => [
                'Sed',
                'convallis',
                'nibh',
            ],
        ],
        2 => [
            'id' => 2,
            'title' => 'Etiam diam ipsum, dignissim eget suscipit nec, faucibus accumsan felis',
            'content' => 'Nullam malesuada ipsum non ligula feugiat consequat. Aliquam quis magna condimentum, pharetra dui eget, gravida ipsum. Donec porta fringilla sagittis. Donec vel ante sit amet mauris faucibus vehicula ac quis enim. Nunc maximus, neque sed tristique elementum, velit ex ornare augue, quis malesuada ante ligula vitae arcu. Sed convallis, est et pulvinar placerat, leo dui dictum tortor, vitae vehicula mauris turpis sit amet eros. Proin ultrices, nunc a aliquam accumsan, nisi ligula vulputate libero, a dapibus nulla felis in diam. Sed egestas metus condimentum egestas facilisis.',
            'tags' => [
                'Phasellus',
                'vestibulum',
                'tortor',
            ],
        ],
        3 => [
            'id' => 3,
            'title' => 'Nullam eget dui blandit, scelerisque lacus a, sagittis nibh',
            'content' => 'Sed hendrerit, libero non facilisis semper, nibh nunc maximus mi, eget sollicitudin neque justo a ante. Cras iaculis risus vel massa efficitur auctor. Aliquam vulputate urna feugiat sapien porta, a accumsan est efficitur. Praesent pharetra tempus malesuada. Nunc nec quam placerat, pretium ligula id, ultricies ipsum. Suspendisse vel arcu leo. Aenean ultrices erat id turpis consectetur vestibulum. Duis accumsan aliquet tristique. Nulla ut massa ac nunc consequat facilisis. Sed sodales porta ligula. Curabitur faucibus pulvinar nunc ut efficitur. Suspendisse in sem euismod odio interdum aliquet et eget velit. Duis a quam in nulla pharetra efficitur. Vivamus aliquet est ut tempus consectetur. Cras vel leo dignissim, elementum risus auctor, placerat ligula. Integer laoreet libero at pretium sodales.',
            'tags' => [
                'Curabitur',
                'consectetur',
                'porttitor',
            ],
        ],
    ];

    /**
     * Find all.
     *
     * @return array Result
     */
    public function findAll(): array
    {
        return $this->data;
    }

    /**
     * Find one by Id.
     *
     * @param int $id Id
     *
     * @return array|null Result
     */
    public function findById(int $id): ?array
    {
        return isset($this->data[$id]) && count($this->data)
            ? $this->data[$id] : null;
    }
}