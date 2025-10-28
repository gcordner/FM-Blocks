import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
registerBlockType("plk/front-hero", { edit: Edit, save: () => null });
