import AbstractApiRepository from '@wexample/js-api/Common/AbstractApiRepository';
import Configuration from '../Entity/Configuration.js';

export default class ConfigurationRepository extends AbstractApiRepository<Configuration> {
  static getEntityType() {
    return Configuration;
  }
}
