import AbstractApiEntity from '@wexample/js-api/Common/AbstractApiEntity';
import schema from '../data/entity/configuration.json';

export default class Configuration extends AbstractApiEntity {
  static readonly entityName = 'configuration';

  static retrieveEntitySchema() {
    return schema;
  }
}
