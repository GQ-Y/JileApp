<?php

namespace Plugin\MineAdmin\CodeGenerator\Model\Enums;

enum SearchTypeEnum : string
{
    case EQ = 'eq';

    case NE = 'ne';

    case GT = 'gt';

    case GE = 'ge';

    case LT = 'lt';

    case LE = 'le';

    case LIKE = 'like';

    case IN = 'in';

    case NOT_IN = 'not_in';

    case BETWEEN = 'between';

    case NOT_BETWEEN = 'not_between';

    case IS_NULL = 'is_null';

    case IS_NOT_NULL = 'is_not_null';

}
