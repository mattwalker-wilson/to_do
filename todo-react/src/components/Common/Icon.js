import { FaTimes, FaCheck } from 'react-icons/fa';

function Icon({ completed }) {
  return completed ? <FaCheck color="green" /> : <FaTimes color="red" />;
}

export default Icon;