import { environment } from '../../environments/environment';

export const SystemConstants = {
  ...environment,
  api: `${environment.protocol}${environment.resource}`,
};
