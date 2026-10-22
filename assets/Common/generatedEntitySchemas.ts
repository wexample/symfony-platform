import configuration from '../data/entity/configuration.json';

type EntitySchema = { name: string };

export default function getGeneratedEntitySchemas(): Record<string, EntitySchema> {
  return {
    [configuration.name]: configuration,
  };
}
