import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
registerBlockType("fm/front-hero", { edit: Edit, save: () => null });
