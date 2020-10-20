<?php


namespace Jc\GraphQlDemo\Model\Resolver;


use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;

class Blog implements ResolverInterface
{
    /**
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     * Blog constructor.
     * @param ValueFactory $valueFactory
     */
    public function __construct(
        ValueFactory $valueFactory
    )
    {
        $this->valueFactory = $valueFactory;
    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return Value|mixed
     * @throws \Exception
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        try {
            $blog = $this->getBlogArray();// Here, instead of array, we can get data from database tables using collections
            $result = function () use ($blog) {
                return !empty($blog) ? $blog : [];
            };
            return $this->valueFactory->create($result);
        } catch (\Exception $exception) {
            throw new \Exception(__($exception->getMessage()));
        }
    }

    /**
     *  Getting Blog array using Blog Collection
     */
    private function getBlogArray() {
        $blog = [
            'entity_id' => 1,
            'blog_name' => 'Some Blog Name',
            'author' => 'Some Author Name',
            'blog_content' => 'hi, this is blog content'
        ];
        return $blog;
    }
}
